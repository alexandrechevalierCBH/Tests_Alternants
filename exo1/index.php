<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knp. Exo 1</title>
</head>

<body>
    <p>
        To solve this test, i firstly thought about pushing the even numbers into an array and then sum them up.<br>
        Then i realized that it was not necessary to push them into an array. So i just sum them up in the while loop.<br>
        By the way, here are the 2 solutions, one in JS and the other one in PHP.<br>
    </p>
    <hr width="50%">
    <p>
        Here is the result, using JS, doing the sum of the even numbers:
        <span id="fibonacciJs"></span>
    </p>
    <hr width="50%">
    <p>
        Sum of the even numbers of the sequence:
        <span>
            <?= array_sum(fibonacciTest()) ?>
        </span>
    </p>
    <p>
        Even numbers of the Fibonacci sequence:
        <span>
            <?php
            $end = fibonacciTest()[count(fibonacciTest()) - 1];
            foreach (fibonacciTest() as $number) {
                if ($number === $end) {
                    echo $number;
                } else {
                    echo $number . ', ';
                }
            }
            ?>
        </span>
    </p>


</body>

</html>

<?php
function fibonacciTest(int $limit = 4000000): array
{
    $a = 0;
    $b = 1;
    $c = 0;
    $evenNumbers = [];

    while ($c < $limit) {
        $c = $a + $b;
        $a = $b;
        $b = $c;

        if ($c % 2 === 0) {
            $evenNumbers[] = $c;
        }
    }
    return $evenNumbers;
}
?>

<script>
    function fibonacciJs(limit = 4000000) {
        var a = 0;
        var b = 1;
        var c = 0;
        var sum = 0;
        while (c < 4000000) {
            c = a + b;
            a = b;
            b = c;
            if (c % 2 == 0) {
                sum += c;
            }
        }
        return sum;
    }

    function displayFibonacciJs() {
        document.getElementById("fibonacciJs").innerHTML = fibonacciJs();
    }

    displayFibonacciJs();
</script>

<style>
    span {
        font-weight: bold;
    }
</style>