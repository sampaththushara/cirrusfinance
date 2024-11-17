<?php

use yii\helpers\Html;
use app\models\CaGroup;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\ArrayHelper;

$this->title = 'Chart of Account List';
$this->params['breadcrumbs'][] = $this->title;
$this->params['selectedBtn'] = "reports";
?>

<div class="coa-list">

    <div class="admin-form theme-primary mw1000 center-block">

        <div class="panel-body bg-light">
            <div class="section-divider mt20 mb40">
                <span class="panel-title"><?= Html::encode($this->title) ?></span>
            </div>

            <a class="btn btn-primary btn-float-right btn-print" href='index.php?r=cagroup/coa-list-pdf' target='_blank' title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>

			<?php

			$parents_1 = CaGroup::find()->where(['statement_type_id' => 1, 'parent_id' => NULL])->all();
			$parents_2 = CaGroup::find()->where(['statement_type_id' => 2, 'parent_id' => NULL])->all();

			?>

			<div class="row view-list">
				<div class="col-sm-6 col-xs-12">

					<h3>Balance Sheet Items</h3>

					<?php

					foreach ($parents_1 as $parent) {

						$parent_name = $parent->parent_name;
						echo "<pre>".$parent_name."</pre>";
						$level_2 = CaGroup::find()->where(['ca_level' => 2, 'parent_name' => $parent_name])->all();

						foreach ($level_2 as $item_level_2) {

							$level_2_id = $item_level_2->id;
							$item_name_level_2 = $item_level_2->item_name;
							echo "<div class='level-2'>".$item_name_level_2."<div class='view-code'>".$item_level_2->code."</div></div>";

							$level_3 = CaGroup::find()->where(['parent_id' => $level_2_id , 'statement_type_id' => 1, 'ca_level' => 3])->all();

							foreach ($level_3 as $item_level_3) {
								
								echo "<div class='level-3'>".$item_level_3->item_name."<div class='view-code'>".$item_level_3->code."</div></div>";
								
							}

						}

					}

					?>
					
				</div>
				<div class="col-sm-6 col-xs-12">

					<h3>Profit & Loss Items</h3>

					<?php

					foreach ($parents_2 as $parent) {

						$parent_name = $parent->parent_name;
						echo "<pre>".$parent_name."</pre>";
						$level_2 = CaGroup::find()->where(['ca_level' => 2, 'parent_name' => $parent_name])->all();

						foreach ($level_2 as $item_level_2) {
							
							$item_name_level_2 = $item_level_2->item_name;
							$level_2_id = $item_level_2->id;
							echo "<div class='level-2'>".$item_name_level_2."<div class='view-code'>".$item_level_2->code."</div></div>";

							$level_3 = CaGroup::find()->where(['parent_id' => $level_2_id, 'statement_type_id' =>2, 'ca_level' => 3])->all();

							foreach ($level_3 as $item_level_3) {
								echo "<div class='level-3'>".$item_level_3->item_name."<div class='view-code'>".$item_level_3->code."</div></div>";
								
							}

						}

					}

					?>
					
					
				</div>
			</div>
		
     	</div>

    </div>

</div>
