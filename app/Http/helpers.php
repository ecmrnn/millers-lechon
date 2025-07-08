<?php 

function generateId($prefix = '') {
    return strtoupper($prefix) . '-' . now()->format('ymd') . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
}