<?php

namespace App\Traits;

trait WithToast
{
    public function toast($message, $type = 'success', $description = '') {
        $toastData = json_encode([
            'message' => $message,
            'type' => $type,
            'description' => $description
        ]);

        $this->dispatch('toast', $toastData);
    }
}
