<?php
require_once('config.php');

// GRID SIZE
$grid = (isset($_REQUEST['grid']) && $_REQUEST['grid']) ? $_REQUEST['grid'] : '4';
$grid = string_integer($grid);
if ( $grid == 0 || $grid > 6 ) {
	echo '<h1>Sorry any number greater than 6 consumes too much resources.</h1>';
	exit();
	die();
}
// MAGIC CONSTANT
$magic = (($grid*$grid+1)*$grid/2);
// ARRAY OF NUMBERS
$grid_squared = gmp_strval(gmp_pow($grid,2));
for ($x=1; $x<=$grid_squared; $x++) {
$numbers[] = $x;
}
// GENERATE PERMUTATIONS
generate(0, $grid, array(), $magic);
// WEED OUT INVALID PERMUATIONS
$total_permx = count($solutions);
for ($i=0; $i<$total_permx; $i++ ) {
	if ( array_sum($solutions[$i]) == $magic ) {
		$permutations[] = $solutions[$i];
	} 
}
// TOTAL VALID PERMUTATIONS
$valid_permutations = count($permutations);
for ( $i=0; $i<$valid_permutations; $i++) {
	$html_table[] = table_grid_print($grid, $i, $permutations);
}

$flatten_permutations = array_flatten($permutations);
$count_permutation_numbers = array_count_values($flatten_permutations);
ksort($count_permutation_numbers);

$info_txt[] = '<h4>';
$info_txt[] = '<span class="bold">'.count($permutations).'</span> PERMUTATIONS THAT ADD TO ';
$info_txt[] = '<span class="bold">'.$magic.'</span> WHEN CONNECTING ';
$info_txt[] = '<span class="bold">'.$grid.'</span> NUMBERS IN A ';
$info_txt[] = '<span class="bold">'.$grid.'<span class="black">x</span>'.$grid.'</span> GRID';
$info_txt[] = '</h4>';

$meta_title = join("", $info_txt);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="address=no,email=no,telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>NUMERICAL GRID SQUARES <?php echo trim(strip_tags($meta_title)); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/style.css?v=1"/>
</head>
<body>
<div class="p-2"></div>
<div class="container text-center form" style="width: 200px;">
<form action="?" method="GET" class="form-inline" >	
<div class="row">
<div class="col-sm-10 col-md-11 text-center p-2"><input type="number" class="form-control form-control-lg" placeholder="magic square <?php echo strip_tags($gridx); ?> grid" value="<?php echo $grid; ?>" name="grid"></div>
<div class="col-sm-2 col-md-1 text-center p-2"><input type="submit" value="GO"  class="btn btn-primary btn-lg" /></div>
</form>
</div>
</div>
<div class="text-center">
<?php echo join("\n", $info_txt);?>
<h6>A heuristic approach to find <b>all</b> Magic Squares for a given number. Once you reach a 6x6 grid you have 32134 valid permutations. Due to memory and cpu constraints any number greater than 6 was not viable, and thus the experiment to find all magic squares for a given number failed.</h6>
</div>
<?php echo table_grid_heatmap($count_permutation_numbers, $grid); ?>
<?php echo join("\n", $html_table); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>
