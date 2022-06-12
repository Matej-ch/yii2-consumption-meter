<?php

namespace matejch\iot24meter\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class Iot24PriceMapDataSearch extends Iot24PriceMapData
{
    public function rules(): array
    {
        return [
            [['created_at', 'updated_at', 'device_id', 'channel', 'from', 'to'], 'string'],
            [['price'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = Iot24PriceMapData::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        if (!empty($this->channel)) {
            $devicesIDs = Iot24Device::find()->select('device_id')->where(['like', 'aliases', $this->channel])->column();
            $query->andFilterWhere(['like', 'device_id', $devicesIDs]);
        }

        $query
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at])
            ->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'to', $this->to]);

        return $dataProvider;
    }
}