<?php

namespace backend\models\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\db\Game;

/**
 * GameSearch represents the model behind the search form of `common\models\db\Game`.
 */
class GameSearch extends Game
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'money_balance', 'money_from', 'money_to', 'bonus_from', 'bonus_to', 'money_share', 'gift_share', 'bonus_share'], 'integer'],
            [['name', 'start', 'end'], 'safe'],
            [['conversion_rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Game::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'conversion_rate' => $this->conversion_rate,
            'money_balance' => $this->money_balance,
            'money_from' => $this->money_from,
            'money_to' => $this->money_to,
            'bonus_from' => $this->bonus_from,
            'bonus_to' => $this->bonus_to,
            'money_share' => $this->money_share,
            'gift_share' => $this->gift_share,
            'bonus_share' => $this->bonus_share,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
