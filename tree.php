<?php
$tree = [];
$handle = @fopen(__DIR__."/data.txt", "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        list($id, $parent, $name) = explode("|", $buffer);
        $tree[$parent][] = [
            'id' => $id,
            'name' => $name
        ];
    }
    fclose($handle);
}

function createTree(&$list, $parent){
    $tree = array();
    foreach ($parent as $k=>$l){
        if(isset($list[$l['id']])){
            $l['children'] = createTree($list, $list[$l['id']]);
        }
        $tree[] = $l;
    } 
    return $tree;
}

function printTree($tree, $deep = 0){
    foreach ($tree as $node) {
        echo str_repeat('-', $deep) . $node['name'];
        if (isset($node['children']))
            printTree($node['children'], $deep + 1);
    }
}

$tree = createTree($tree, $tree[0]);
printTree($tree);
