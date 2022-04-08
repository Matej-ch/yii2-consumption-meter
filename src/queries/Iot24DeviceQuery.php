<?php

namespace matejch\iot24meter\queries;

use yii\db\ActiveQuery;

class Iot24DeviceQuery extends ActiveQuery
{
    public function active($active = true): Iot24DeviceQuery
    {
        return $this->andOnCondition(['is_active' => $active]);
    }
}