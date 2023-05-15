<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class PracticeController extends Controller
{
    public array $numbers=array(4,3,5,6,10,7,1,9,8,2);

    public function min(): int
    {
       $size=count($this->numbers);
       $currentMin=$this->numbers[0];
       for($i=0;$i<$size;$i++){
           if($this->numbers[$i]<$currentMin){
               $currentMin=$this->numbers[$i];
           }
       }
       return $currentMin;
    }

    public function max(): int
    {
        $size=count($this->numbers);
        $currentMax=$this->numbers[0];
        for($i=0;$i<$size;$i++){
            if($this->numbers[$i]>$currentMax){
                $currentMax=$this->numbers[$i];
            }
        }
        return $currentMax;
    }

    public function sortingAlgorithm() :array
    {
        $size=count($this->numbers);
        for($i=0;$i<$size-1;$i++){
            if($this->numbers[$i + 1] < $this->numbers[$i] ) {
                $temp = $this->numbers[$i +1];
                $this->numbers[$i + 1] = $this->numbers[$i];
                $this->numbers[$i] = $temp;
                $i=-1;
            }
        }
        return $this->numbers;
    }


    public function hasDuplicate(): bool
    {
        return count($this->numbers) !== count(array_unique($this->numbers));
    }


    public function findMissing() :array
    {
        $maximum=$this->max();
        $actualMissing=[];
        for($s=1;$s<$maximum;$s++){
            $missing = in_array($s,$this->numbers,true);
            if($missing!=$s){
                $actualMissing[] = $s;
            }

        }
        return $actualMissing;
    }


    public function findAllEven() :array
    {
        $evenNumbers=[];
        $size=count($this->numbers);
        for($i=0;$i<$size;$i++){
            if($this->numbers[$i] % 2==0){
                 $evenNumbers[]=$this->numbers[$i];
            }
        }
        return $evenNumbers;
    }


    public function findAllOdd() :array
    {   $oddnumbers=[];
        $size=count($this->numbers);
        for($i=0;$i<$size;$i++){
            if($this->numbers[$i] % 2 !=0){
                $oddnumbers[]=$this->numbers[$i];
            }
        }
        return $oddnumbers;
    }


    public function factorial(int $number) :int
    {
        $factorial=1;
        for($x=$number;$x>=1;$x--)
        {
           $factorial=$factorial * $x;
        }
        return $factorial;
    }

    public function sumOfDigits() : int
    {
        $number=14597;
        $array  = array_map('intval', str_split($number));
        $size=count($array);
        $sum=0;
        for($i=0;$i<$size;$i++){
           $sum = $sum + $array[$i];
        }
        return $sum;
    }


    public function loopThroughArrayMap():iterable
    {
       return User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        });

     }



}
