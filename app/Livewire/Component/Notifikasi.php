<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Notifikasi extends Component
{
    public array $notifications = [];
    private int $counter = 0;

    protected $listeners = [
        'notify'          => 'addNotification',
        'notifySuccess'   => 'success',
        'notifyError'     => 'error',
        'notifyWarning'   => 'warning',
        'notifyInfo'      => 'info',
        'notifyConfirm'   => 'confirm',
    ];

    public function addNotification(
        string $type,
        string $message,
        string $title = '',
        int $duration = 4000,
        ?string $confirmAction = null,
        ?string $confirmParams = null
    ): void {
        $id = uniqid('notif_');

        $this->notifications[] = [
            'id'             => $id,
            'type'           => $type,   // success | error | warning | info | confirm
            'message'        => $message,
            'title'          => $title ?: $this->defaultTitle($type),
            'duration'       => $duration,
            'confirmAction'  => $confirmAction,
            'confirmParams'  => $confirmParams,
            'visible'        => true,
        ];
    }

    // Shorthand helpers
    public function success(string $message, string $title = ''): void
    {
        $this->addNotification('success', $message, $title);
    }

    public function error(string $message, string $title = ''): void
    {
        $this->addNotification('error', $message, $title, 6000);
    }

    public function warning(string $message, string $title = ''): void
    {
        $this->addNotification('warning', $message, $title, 5000);
    }

    public function info(string $message, string $title = ''): void
    {
        $this->addNotification('info', $message, $title);
    }

    /**
     * Show a confirm dialog.
     *
     * @param  string  $message        Pertanyaan konfirmasi
     * @param  string  $confirmAction  Livewire event yang akan di-dispatch saat dikonfirmasi
     * @param  string  $confirmParams  JSON string parameter opsional, misal: '{"id":5}'
     * @param  string  $title          Judul opsional
     */
    public function confirm(
        string $message,
        string $confirmAction = '',
        string $confirmParams = '',
        string $title = 'Konfirmasi'
    ): void {
        $this->addNotification('confirm', $message, $title, 0, $confirmAction, $confirmParams);
    }

    public function dismiss(string $id): void
    {
        $this->notifications = array_values(
            array_filter($this->notifications, fn($n) => $n['id'] !== $id)
        );
    }

    public function handleConfirm(string $id): void
    {
        $notif = collect($this->notifications)->firstWhere('id', $id);

        if ($notif && $notif['confirmAction']) {
            $params = $notif['confirmParams']
                ? json_decode($notif['confirmParams'], true)
                : [];

            $this->dispatch($notif['confirmAction'], ...(array) $params);
        }

        $this->dismiss($id);
    }

    private function defaultTitle(string $type): string
    {
        return match ($type) {
            'success' => 'Berhasil',
            'error'   => 'Terjadi Kesalahan',
            'warning' => 'Perhatian',
            'info'    => 'Informasi',
            'confirm' => 'Konfirmasi',
            default   => '',
        };
    }

    public function render()
    {
        return view('livewire.component.notifikasi');
    }
}
