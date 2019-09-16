<?php


namespace App\Repositories;

class Staircase
{
    public function getSteps(int $n, array $x)
    {
        $total = 0;

        if ($n < 0)
            return 0;
        else if ($n == 0) {
            echo "\n";
            return 1;
        } else {
            foreach ($x as $item) {
                echo $n . ' when x is ' . $item . "\n";
                $total += $this->getSteps($n - $item, $x);
            }
        }

        return $total;
    }

    public function greet($name)
    {
        $valid = ['Bob', 'Alice'];

        if (in_array($name, $valid)) {
            return 'Hello, ' . $name . '!';
        }

        return 'Unauthorized';
    }

    public function sum($num)
    {
        $total = 0;

        while ($num >= 1) {
            if ($num % 3 == 0 || $num % 5 == 0)
                $total += $num;
            $num--;
        }

        return $total;
    }

    public function multiplicationTable($num)
    {
        if ($num == 0) {
            return;
        } else {
            $count = 1;

            while ($count <= 12) {
                echo $num . " x " . $count . " = " . $num * $count . "\n";
                $count++;
            }

            $this->multiplicationTable($num - 1);
        }
    }

    public function binarySearch(array $data, $needle)
    {
        $low = 0;
        $high = count($data) - 1;
        $found = "Not found";

        while ($low <= $high) {
            $mid = ceil(($low + $high) / 2);
            if ($data[$mid] == $needle) {
                $found = "Found at " . $mid;

                return $found;
            } else {
                if ($needle < $data[$mid]) {
                    $high = $mid - 1;
                } else {
                    $low = $mid + 1;
                }
            }
        }

        return $found;
    }
}
