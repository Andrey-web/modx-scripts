<?php
$arr = [
	['article' => '', 'old_price' =>'11180', 'price' =>'10620', 'disc' => '5'],
	['article' => '', 'old_price' =>'10000', 'price' =>'', 'disc' => ''],
];

foreach ($arr as $one) {
    $where = ['article' => $one['article']];
   
    $option = $modx->getObject('msProductData', $where);
   
    if (isset($option)) {
        $product = $modx->getObject('msProduct', $option->id);
    if (empty($one['old_price'])) {
        continue;
    }
    $product->set('old_price', $one['old_price']);
    if (NULL == $one['disc']) {
        $product->set('discountpercent', '');
    } else {
        $product->set('discountpercent', $one['disc']);
    }
    
    if (empty($one['price'])) {
        if (empty($one['disc'])) {
            $product->set('price', $one['old_price']);
        } else {
            $percent = $one['old_price'] / 100;
            $price = $one['old_price'] - ($percent * $one['disc']);
            $product->set('price', floor($price/10)*10);
        }
    } else {
    	$product->set('price', $one['price']);
    }

    $product->save();
    }
}
