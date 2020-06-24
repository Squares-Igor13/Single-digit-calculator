<?php

$example = '3+8*9/2-2*3';

$example2 = '3*5+9/3*2-6*7/2+4*4-9';

$example3 = '5+6-2+6-9+4-9+6-2+1-3+2+4+4+1+9+6';



function superCalc($str) {
	echo "<h1>$str = ???</h1>";
	//разбиваем на числа и знаки 
	$arr = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);

	//ищем все варианты с умножением и заменяем два множителя и знак умножения на результат
	//пока находим знак деления, выполняем это действие
	$del = true;
	while($del) {
		//находим позицию знака в массивк
		$del = array_search('/', $arr)??false;

		if($del) {
			//применяем обычный калькулятор к найденному знаку и цифрам справа и слева от него
			$delRes = calc(array($arr[$del-1], $arr[$del], $arr[$del+1]));
			//встяавляем за место этих трех элементов готовый результат (аналогично и дальше)
			array_splice($arr, $del-1, 3, $delRes);
		}
	}

	echo "</p>Выполнили деление (промежуточное действие):<br>".implode(' ', $arr)."</p>";

	//пока находим знак умножения, выполняем это действие
	$mol = true;
	while($mol) {
		$mol = array_search('*', $arr)??false;
		
		if ($mol) {
			$molRes = calc(array($arr[$mol-1], $arr[$mol], $arr[$mol+1]));
			array_splice($arr, $mol-1, 3, $molRes);
		}
	}



	echo "</p>Выполнили умножение (промежуточное действие):<br>".implode(' ', $arr)."</p>";

	//сумма и разница
	//пока находим знак разницы, выполняем это действие
	$minus = true;
	while($minus) {
		$minus = array_search('-', $arr)??false;

		if($minus) {

			$minusRes = calc(array($arr[$minus-1], $arr[$minus], $arr[$minus+1]));
			array_splice($arr, $minus-1, 3, $minusRes);

		}
	}
	

	echo "</p>Выполнили разницу (промежуточное действие):<br>".implode(' ', $arr)."</p>";

	//пока находим знак суммы, выполняем это действие
	$plus = true;
	while($plus) {
		$plus = array_search('+', $arr)??false;
		
		if($plus) {
			$plusRes = calc(array($arr[$plus-1], $arr[$plus], $arr[$plus+1]));

			array_splice($arr, $plus-1, 3, $plusRes);
		}
	}
	
	//для корректного отображения результат
	if($arr[0]==0) {
		$res = $arr[2];
	} else {
		$res = $arr[0];
	}

	echo "</p>Выполнили сумму (получили результат):<br><span style='color:red;'>$res</span></p>";

	echo "<h1>$str = $res</h1>";

}






function calc($arr) {


		switch ($arr[1]) {
			case '+':
				return $arr[0] + $arr[2];
				break;
			case '-':
				return $arr[0] - $arr[2];
				break;
			case '*':
				return $arr[0] * $arr[2];
				break;
			case '/':
				return $arr[0] / $arr[2];
				break;
			default:
				# code...
				break;
		}
	
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Calculator</title>
</head>
<body>

	<form action="4.php">
		<label for="calc">Введите в строку однозначные числа и действия над нами<br>(например: 3+8*9-2*3)</label><br>
		<input type="text" id="calc" name="calc"><br><br>
		<button>Result</button>
	</form>

	<?php

		$calc = $_GET['calc']??false;

		if($calc) {
			superCalc($calc);
		}

	?>
	
</body>
</html>