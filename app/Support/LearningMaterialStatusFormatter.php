<?php
declare(strict_types=1);

namespace App\Support;

use Config\Processes;

final class LearningMaterialStatusFormatter
{
    private const BADGE_BASE = 'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold';

    private const LABEL_MAP = [
        'draft' => 'Taslak',
        'submitted' => 'Gönderildi',
        'review' => 'İncelemede',
        'approved' => 'Onaylandı',
        'published' => 'Yayınlandı',
        'rejected' => 'Reddedildi',
        'archived' => 'Arşivlendi',
        'on_inceleme' => 'Ön İnceleme',
        'korhakemlik' => 'Hakem Değerlendirmesi',
        'editorkontrol' => 'Editör Kontrolü',
        'revizyonok' => 'Revizyon',
        'yayinla' => 'Yayınlanacak',
        'end' => 'Tamamlandı',
        '0' => 'Pasif',
        '1' => 'Aktif',
    ];

    private const COLOR_MAP = [
        'draft' => 'warning',
        'submitted' => 'info',
        'review' => 'info',
        'approved' => 'success',
        'published' => 'success',
        'rejected' => 'destructive',
        'archived' => 'secondary',
        'on_inceleme' => 'info',
        'korhakemlik' => 'warning',
        'editorkontrol' => 'primary',
        'revizyon' => 'warning',
        'revizyonok' => 'info',
        'yayinla' => 'success',
        'yayinlandi' => 'success',
        'end' => 'success',
        '0' => 'secondary',
        '1' => 'success',
        'onay' => 'success',
        'red' => 'destructive',
        'assign_reviewers' => 'info',
        'yayinla_al' => 'success',
    ];

    private const HISTORY_STYLE_MAP = [
        'draft' => ['bg' => '#f8fafc', 'text' => '#1e293b', 'border' => '#e2e8f0'],
        'submitted' => ['bg' => '#eef2ff', 'text' => '#3730a3', 'border' => '#c7d2fe'],
        'egitim_icerigi_basvurusu' => ['bg' => '#eef2ff', 'text' => '#3730a3', 'border' => '#c7d2fe'],
        'review' => ['bg' => '#e0f2fe', 'text' => '#075985', 'border' => '#bae6fd'],
        'on_inceleme' => ['bg' => '#f3e8ff', 'text' => '#6b21a8', 'border' => '#e9d5ff'],
        'korhakemlik' => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fcd34d'],
        'assign_reviewers' => ['bg' => '#e0f2fe', 'text' => '#0369a1', 'border' => '#bae6fd'],
        'editorkontrol' => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'border' => '#bfdbfe'],
        'revizyon' => ['bg' => '#fff7ed', 'text' => '#9a3412', 'border' => '#fed7aa'],
        'revizyonok' => ['bg' => '#fff7ed', 'text' => '#9a3412', 'border' => '#fed7aa'],
        'onizleme' => ['bg' => '#e0f2fe', 'text' => '#1d4ed8', 'border' => '#bfdbfe'],
        'yayinla' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
        'yayinlandi' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
        'published' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
        'approved' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
        'onay' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
        'rejected' => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'border' => '#fca5a5'],
        'red' => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'border' => '#fca5a5'],
        'yayinla_al' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
        'end' => ['bg' => '#f1f5f9', 'text' => '#0f172a', 'border' => '#e2e8f0'],
    ];

    private static ?array $processNameCache = null;

    public static function label(string $status): string
    {
        $key = self::normalize($status);
        if ($key === '') {
            return 'Bilinmiyor';
        }

        if (isset(self::LABEL_MAP[$key])) {
            return self::LABEL_MAP[$key];
        }

        $processName = self::resolveProcessName($key);
        if ($processName !== null && $processName !== '') {
            return $processName;
        }

        return ucwords(str_replace('_', ' ', $key));
    }

    public static function color(string $status): string
    {
        $key = self::normalize($status);
        if ($key === '') {
            return 'primary';
        }

        return self::COLOR_MAP[$key] ?? 'primary';
    }

    public static function badgeClasses(string $status): array
    {
        $intent = self::color($status);

        $base = 'kt-badge kt-badge-outline';
        $class = match ($intent) {
            'success' => "{$base} kt-badge-success",
            'warning' => "{$base} kt-badge-warning",
            'info' => "{$base} kt-badge-info",
            'destructive' => "{$base} kt-badge-danger",
            'secondary' => "{$base} kt-badge-secondary",
            default => "{$base} kt-badge-primary",
        };

        return [
            'badge' => $class,
            'text' => "status-{$intent}",
        ];
    }

    public static function historyClasses(string $status): array
    {
        $normalized = self::normalize($status);
        if ($normalized !== '' && isset(self::HISTORY_STYLE_MAP[$normalized])) {
            return self::formatHistoryBadge(self::HISTORY_STYLE_MAP[$normalized]);
        }

        $intent = self::color($status);
        return self::formatHistoryBadge(self::styleForIntent($intent));
    }

    private static function formatHistoryBadge(array $style): array
    {
        $bg = $style['bg'] ?? '#f1f5f9';
        $text = $style['text'] ?? '#1f2937';
        $border = $style['border'] ?? '#e2e8f0';

        return [
            'badge' => self::BADGE_BASE,
            'style' => sprintf('background-color:%s;color:%s;border:1px solid %s;', $bg, $text, $border),
        ];
    }

    private static function styleForIntent(string $intent): array
    {
        return match ($intent) {
            'success' => ['bg' => '#dcfce7', 'text' => '#166534', 'border' => '#86efac'],
            'warning' => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fcd34d'],
            'info' => ['bg' => '#e0f2fe', 'text' => '#0369a1', 'border' => '#bae6fd'],
            'destructive' => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'border' => '#fca5a5'],
            'secondary' => ['bg' => '#f1f5f9', 'text' => '#0f172a', 'border' => '#e2e8f0'],
            default => ['bg' => '#eef2ff', 'text' => '#3730a3', 'border' => '#c7d2fe'],
        };
    }

    private static function resolveProcessName(string $key): ?string
    {
        if (self::$processNameCache === null) {
            $processes = (new Processes())->getProcesses();
            self::$processNameCache = [];
            foreach ($processes as $code => $definition) {
                if (!is_string($code)) {
                    continue;
                }
                $name = $definition['name'] ?? null;
                if (is_string($name) && $name !== '') {
                    self::$processNameCache[trim(strtolower($code))] = $name;
                }
            }
        }

        return self::$processNameCache[$key] ?? null;
    }

    private static function normalize(string $status): string
    {
        $normalized = strtolower(trim($status));
        $normalized = str_replace([' ', '-'], '_', $normalized);
        return $normalized;
    }
}
