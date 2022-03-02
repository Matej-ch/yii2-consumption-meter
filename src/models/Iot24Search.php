<?php

namespace matejch\iot24meter\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class Iot24Search extends Iot24
{
    public function rules(): array
    {
        return [
            [['created_by', 'updated_by', 'system_id', 'id'], 'integer'],
            [['increments', 'values', 'device_id', 'device_type', 'created_at', 'updated_at', 'status', 'aliases'], 'string'],
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
            'sort' => [
                'defaultOrder' => [
                    'system_id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'updated_by' => $this->updated_by,
            'system_id' => $this->system_id,
            'created_by' => $this->created_by,
        ]);

        $query
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['OR',
                ['like', 'increments', $this->increments],
                ['like', 'values', $this->values]])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'downloaded_at', $this->downloaded_at]);

        $query->andFilterWhere(['like', 'device_id', $this->device_type]);

        return $dataProvider;
    }
}