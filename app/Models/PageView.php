<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = ['type', 'reference_id', 'session_id', 'ip_address', 'user_agent', 'referrer', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Record a page view (one per session per page).
     */
    public static function record(string $type, ?int $referenceId = null): void
    {
        $session = self::sessionKey($type, $referenceId);

        if (session()->has($session)) {
            return; // already recorded in this session, avoid double count
        }

        $request = request();

        self::create([
            'type'         => $type,
            'reference_id' => $referenceId,
            'session_id'   => session()->getId(),
            'ip_address'   => $request?->ip(),
            'user_agent'   => mb_substr((string) $request?->userAgent(), 0, 500),
            'referrer'     => $request?->headers->get('referer'),
        ]);

        session([$session => true]);
    }

    private static function sessionKey(string $type, ?int $referenceId): string
    {
        return "pv_{$type}_" . ($referenceId ?? 0);
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }
}