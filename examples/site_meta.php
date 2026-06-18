<?php
/**
 * Site Meta Information
 *
 * Holds metadata for the site and provides a method to generate
 * a short description text based on that data.
 */

class SiteMeta
{
    /**
     * @var array<string, mixed>
     */
    private array $meta = [];

    /**
     * @param array $data Initial metadata array
     */
    public function __construct(array $data = [])
    {
        $this->meta = $data;
    }

    /**
     * Set a metadata value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * Get a metadata value.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * Generate a short description text from the stored metadata.
     *
     * @param int $maxLength Maximum length of description
     * @return string
     */
    public function generateDescription(int $maxLength = 150): string
    {
        $parts = [];

        $title = $this->meta['title'] ?? '';
        $keywords = $this->meta['keywords'] ?? [];
        $url = $this->meta['url'] ?? '';
        $extra = $this->meta['extra'] ?? '';

        if (!empty($title)) {
            $parts[] = $title;
        }

        if (!empty($keywords) && is_array($keywords)) {
            $keywordStr = implode(', ', $keywords);
            $parts[] = $keywordStr;
        }

        if (!empty($url)) {
            $parts[] = $url;
        }

        if (!empty($extra)) {
            $parts[] = $extra;
        }

        $description = implode(' — ', $parts);

        if (mb_strlen($description) > $maxLength) {
            $description = mb_substr($description, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Return all metadata as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->meta;
    }
}

// -------------------------------------------------------------------
// Example usage / demonstration (not executed on autoload)
// -------------------------------------------------------------------

$siteMeta = new SiteMeta([
    'title'    => '开云kaiyun — 娱乐资讯平台',
    'keywords' => ['开云kaiyun', '游戏', '娱乐', '资讯'],
    'url'      => 'https://kaiyun-funzone.com.cn',
    'extra'    => '提供最新游戏动态与行业分析',
]);

$siteMeta->set('author', 'KaiYun Team');

echo $siteMeta->generateDescription(120) . "\n";
// Output: 开云kaiyun — 娱乐资讯平台 — 开云kaiyun, 游戏, 娱乐, 资讯 — https://kaiyun-funzone.com.cn — 提供最新游戏动态与行业分析