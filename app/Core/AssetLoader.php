<?php
declare(strict_types=1);
final class AssetLoader
{
    private string $baseUrl;
    private string $environment;
    private string $manifestPath;
    private string $viteDevServer;
    public function __construct(array $config)
    {
        $this->baseUrl = rtrim((string) ($config['base_url'] ?? ''), '/');
        $this->environment = (string) ($config['environment'] ?? 'production');
        $this->manifestPath = (string) ($config['manifest_path'] ?? '');
        $this->viteDevServer = rtrim((string) ($config['vite_dev_server'] ?? ''), '/');
        if (!in_array($this->environment, ['development', 'production'], true)) throw new InvalidArgumentException('APP_ENV must be development or production.');
    }
    public function renderStylesheet(string $path): string
    {
        if (str_contains($path, '..') || !preg_match('#^assets/[a-zA-Z0-9_./-]+$#', $path)) throw new InvalidArgumentException('Invalid asset path.');
        $url = $this->baseUrl . '/' . ltrim($path, '/');
        return sprintf('<link rel="stylesheet" href="%s">' . PHP_EOL, $this->escape($url));
    }
    public function renderScripts(string $entry): string
    {
        return $this->environment === 'development' ? $this->renderDevelopmentScripts($entry) : $this->renderProductionScripts($entry);
    }
    private function renderDevelopmentScripts(string $entry): string
    {
        if (str_contains($entry, '..') || !preg_match('#^assets/[a-zA-Z0-9_./-]+$#', $entry)) throw new InvalidArgumentException('Invalid Vite entry.');
        $entry = '/' . ltrim($entry, '/');
        return sprintf('<script type="module" src="%s/@vite/client"></script>' . PHP_EOL . '<script type="module" src="%s%s"></script>' . PHP_EOL, $this->escape($this->viteDevServer), $this->escape($this->viteDevServer), $this->escape($entry));
    }
    private function renderProductionScripts(string $entry): string
    {
        if (!is_file($this->manifestPath) || !is_readable($this->manifestPath)) throw new RuntimeException('Vite manifest is missing or unreadable.');
        $manifest = json_decode((string) file_get_contents($this->manifestPath), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($manifest) || !isset($manifest[$entry]['file']) || !is_string($manifest[$entry]['file'])) throw new RuntimeException('Vite entry is missing from the manifest.');
        $output = '';
        foreach ($manifest[$entry]['css'] ?? [] as $cssFile) {
            if (!is_string($cssFile) || str_contains($cssFile, '..') || !preg_match('#^[a-zA-Z0-9_./-]+$#', $cssFile)) throw new RuntimeException('Invalid CSS path in Vite manifest.');
            $output .= $this->renderStylesheet('assets/build/' . $cssFile);
        }
        $scriptFile = $manifest[$entry]['file'];
        if (str_contains($scriptFile, '..') || !preg_match('#^[a-zA-Z0-9_./-]+$#', $scriptFile)) throw new RuntimeException('Invalid script path in Vite manifest.');
        $scriptUrl = $this->baseUrl . '/assets/build/' . ltrim($scriptFile, '/');
        return $output . sprintf('<script type="module" src="%s"></script>' . PHP_EOL, $this->escape($scriptUrl));
    }
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
