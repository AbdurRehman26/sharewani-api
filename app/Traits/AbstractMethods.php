<?php
namespace App\Traits;

use Carbon\Carbon;

trait AbstractMethods
{

    public function searchCriteria($input)
    {   
        if (!empty($this->model->searchables)) {
            foreach ($input as $key => $value) {
                if (in_array($key, $this->model->searchables)) {
                        
                        if (!(int) $input[$key] && is_string($input[$key])) {
                            $this->builder = $this->builder->where($key, 'like', '%' . $input[$key] . '%');
                        }

                        if (is_array($input[$key])) {
                            $this->builder = $this->builder->whereIn($key, $input[$key]);
                        }

                        if ((int) $input[$key]) {
                            $this->builder = $this->builder->where($key, '=', $input[$key]);
                        }
                }
            }
        }
        return $this->builder;
    }


    public function getMultiLevelArrayValues($dataObject, $key)
    {
        # code...
        $dataArray = [];

        foreach ($dataObject as $dataKey => $data) {
            if ($key == $dataKey && !is_array($data)) {
                $dataArray[] = $data;
            }

            if (is_array($data)) {
                foreach ($data as $valueKey => $value) {
                    # code...
                    $dataArray[] = $value[$key];
                }
            }

        }

        return $dataArray;
    }


    public function activityLogCreateWithDocument($input, $function, $type)
    {
        $inputData['action'] = $type;
        $inputData['type'] = $type;
        $inputData['method'] = $function;
        $inputData['data'] = $input;
        $inputData['case_id'] = $input['case_id'];
        $inputData['case_number'] = $input['case_number'];
        $inputData['user_id'] = $input['user_id'];
        $inputData['created_at'] = Carbon::now()->toDateTimeString();
        $inputData['updated_at'] = Carbon::now()->toDateTimeString();

        $caseCollection =  $this->model->newInstance();
        $caseCollection->case_id = $input['case_id'];

        $this->model = $caseCollection;
        $created = $caseCollection->create($inputData);

        if ($created) {
            $data = $this->findById($created->id, true);

            $logs_data['action'] = $type;
            $logs_data['type'] = 'case_logs';
            $logs_data['method'] = $function;
            $logs_data['data'] = $data->data;
            $logs_data['case_id'] = $input['case_id'];
            $logs_data['case_number'] = $input['case_number'];
            $logs_data['user_id'] = $input['user_id'];
            $logs_data['created_at'] = Carbon::now()->toDateTimeString();
            $logs_data['updated_at'] = Carbon::now()->toDateTimeString();

            $result['document'] = $data;
            $result['log'] = app('ActivityLogRepository')->create($logs_data);

            return $result;
        }
    }


    public function composeActivityLogData($data, $function, $type, $actionType = false)
    {
        if (method_exists($data, 'getAttributes')) {
            $details = $data->getAttributes();
        } else {
            $details = $data;
        }

        if ($actionType) {
            $logs_data['action_type'] = $actionType;
        }
        $logs_data['action'] = $type;
        $logs_data['type'] = 'case_logs';
        $logs_data['method'] = $function;
        $logs_data['data'] =  $details;
        $logs_data['case_id'] = $data->case_id;
        $logs_data['case_number'] = $data->case_number;
        $logs_data['user_id'] = request()->user()->id;
        $logs_data['created_at'] = Carbon::now()->toDateTimeString();
        $logs_data['updated_at'] = Carbon::now()->toDateTimeString();

        return $logs_data;
    }


    public function composeLogData($data, $function, $type)
    {
        # code...
        $inputData['action'] = $type;
        $inputData['type'] = 'case_logs';
        $inputData['method'] = $function;
        $inputData['case_id'] = $data->case_id;
        $inputData['case_number'] = $data->case_number;
        $inputData['user_id'] = request()->user()->id;
        $inputData['created_at'] = Carbon::now()->toDateTimeString();
        $inputData['updated_at'] = Carbon::now()->toDateTimeString();

        return $inputData;
    }


    public function diff($arr1, $arr2)
    {
        $diff = array();

        // Check the similarities
        foreach ($arr1 as $k1 => $v1) {
            if($k1 == 'id' || $k1 == '_id' || $k1 == 'updated_at' || $k1 == 'action' || $k1 == 'method' || $k1 == 'created_at'){
                continue;
            }

            if (isset($arr2[$k1])) {
                $v2 = $arr2[$k1];
                if (is_array($v1) && is_array($v2)) {
                    // 2 arrays: just go further...
                    // .. and explain it's an update!
                    $changes = self::diff($v1, $v2);
                    if (count($changes) > 0) {
                        // If we have no change, simply ignore
                        $diff[$k1] = $changes; //array('upd' => $changes);
                    }
                    unset($arr2[$k1]); // don't forget
                } elseif ($v2 === $v1) {
                    // unset the value on the second array
                    // for the "surplus"
                    unset($arr2[$k1]);
                } else {
                    // Don't mind if arrays or not.
                    $diff[$k1] = array( 'old_value' => $v1, 'new_value'=>$v2 );
                    unset($arr2[$k1]);
                }
            } else {
                // remove information
            }
        }

        // Now, check for new stuff in $arr2
        reset($arr2); // Don't argue it's unnecessary (even I believe you)
        foreach ($arr2 as $k => $v) {
            // OK, it is quite stupid my friend
            //$diff[$k] = array( 'new_value2' => $v );
        }
        return $diff;
    }

    public function getUpdateChanges($item, $array1 = null, $array2 = null)
    {
        if ($item) {
            $array1 = $item->getAttributes();
            $array2 = $item->getOriginal();
        }

        $difference=array();
        foreach ($array1 as $key => $value) {
            if($key == 'id' || $key == '_id' || $key == 'updated_at' || $key == 'action' || $key == 'method' || $key == 'created_at'){
                continue;
            }

            \Log::info(json_encode($value));


            if (is_array($value)) {
                if (!isset($array2[$key]) || !is_array($array2[$key])) {
                    $difference[$key]['old_value'] = !empty($array2[$key]) ? $array2[$key] : null;
                    $difference[$key]['new_value'] = $value;
                } else {
                    $new_diff = self::getUpdateChanges(null, $value, $array2[$key]);
                    if (!empty($new_diff)) {
                        $difference[$key]['old_value'] = !empty($array2[$key]) ? $array2[$key] : null;
                        $difference[$key]['new_value'] = $value;
                    }
                }
            } elseif (!array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key]['old_value'] = !empty($array2[$key]) ? $array2[$key] : null;
                $difference[$key]['new_value'] = $value;
            }
        }

        return $difference;
    }


    public function composeGeneralLog($item)
    {
        $inputData['instance_id'] = $item->id;
        $inputData['instance_type'] = $item->instance_type??$this->model->getTable();
        $inputData['case_id'] = !empty($item->case_id) ? $item->case_id : null;
        $inputData['case_number'] = $item->case_number ?? null;
        $inputData['action'] = $item->action;
        $inputData['user_id'] = request()->user()->id;
        $inputData['difference'] = $item->difference??json_encode($this->getUpdateChanges($item));

        return $inputData;
    }

    public function generateSystemLog($item)
    {
        $input = $this->composeGeneralLog($item);

        app('SystemLogRepository')->create($input);

        return true;
    }


    public function getUpdateChangesWithDiff($item, $array1 = null, $array2 = null)
    {
        if ($item) {
            $array1 = $item->getAttributes();
            $array2 = $item->getOriginal();
            return $this->diff($array1, $array2);
        }
    }

    public function composeGeneralLogWithDiff($item)
    {

        $inputData['instance_id'] = $item->id;
        $inputData['instance_type'] = !empty($item->instance_type)  ? $item->instance_type :  $this->model->getTable();
        $inputData['case_id'] = !empty($item->case_id) ? $item->case_id : null;
        $inputData['case_number'] = !empty($item->case_number) ? $item->case_number : null;
        $inputData['action'] = $item->action;
        $inputData['user_id'] = request()->user()->id;
        $inputData['difference'] = json_encode($this->getUpdateChangesWithDiff($item));

        return $inputData;
    }

    public function generateSystemLogWithDiff($item)
    {
        $input = $this->composeGeneralLogWithDiff($item);

        app('SystemLogRepository')->create($input);

        return true;
    }


    public function findKeyByCriteria($criteria, $key)
    {
        return $this->model->where($criteria)->value($key);
    }



    public function findByCriteria($criteria, $refresh = false, $notCriteria = false, $encode = true, $whereIn = false, $count = false)
    {

        $details = false;


        $model = $this->model->newInstance()
            ->where($criteria);
        if (!empty($notCriteria)) {
            $model  = $model->where(function ($query) use ($notCriteria) {
                foreach ($notCriteria as $key => $where) {
                    $query->where($key, '!=', $where);
                }
            });
        }

        if ($whereIn) {
            $model = $model->whereIn(key($whereIn), $whereIn[key($whereIn)]);

        }

        if ($count) {
            return $model->count();
        }

        $model = $model->first(['id']);

        if ($model != null) {
            $model = $this->findById($model->id, $refresh, $details, $encode);
        }
        return $model;
    }

    public function composeNotificationData($data, $emailTemplate)
    {
        $notificationData = [];
        // $notificationData['url'] = url('student-portal/case-details/'.$data->case_id);
        $notificationData['case_number'] = $data->case_number;
        $notificationData['case_id'] = $data->case_id;
        $notificationData['type'] = $data->type;
        $notificationData['method'] = $data->action;
        $notificationData['_id'] = $data->_id;
        $notificationData['template'] = $emailTemplate;
        $notificationData['data'] = $data->data;

        return $notificationData;
    }


    /*
    * This method helps you find any key in a given object recursively
    * So at any depth it works fine up til now.
    * baaqi aapka nested na chalay tou meri zimmedari nahe
    */

    public function arraySearchKey($needle_key, $array)
    {
        foreach ($array as $key => $value) {
            if ($key == $needle_key) {
                return $value;
            }
            if (is_array($value)) {
                if (($result = $this->arraySearchKey($needle_key, $value)) !== false) {
                    return $result;
                }
            }
        }
        return false;
    }

}
