<?php

namespace matejch\iot24meter\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class Iot24Search extends Iot24
{
    public function rules()
    {
        return [
            [['created_by','updated_by','system_id','id'], 'integer'],
            [['increments','values','device_id','device_type','created_at','updated_at','status'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Iot24::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'updated_by' => $this->updated_by,
            'system_id' => $this->system_id,
            'created_by' => $this->created_by,
        ]);

        $query
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'device_type', $this->device_type])
            ->andFilterWhere(['like', 'increments', $this->increments])
            ->andFilterWhere(['like', 'values', $this->values])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'downloaded_at', $this->downloaded_at]);

        return $dataProvider;
    }
}