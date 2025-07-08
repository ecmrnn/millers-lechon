<?php

namespace App\Traits;

trait WithToast
{
    public function toast($message, $description = null, $type = 'success') {
       $toast = json_encode([
            'message' => $message,
            'type' => $type,
            'description' => $description
        ]);

        $this->dispatch('toast', $toast);
    }
}
