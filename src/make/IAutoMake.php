<?php

namespace laravelCurd\make;
interface IAutoMake
{
    public function check($flag, $path);

    public function make($flag, $path, $other);
}