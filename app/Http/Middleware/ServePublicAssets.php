<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ServePublicAssets
{
    /**
     * Serve files from public/ when Pest Browser falls through to Laravel
     * after a flaky file_exists check under parallel workers.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('testing')) {
            return $next($request);
        }

        clearstatcache();

        $relativePath = $request->path();

        if ($relativePath === '' || $relativePath === '/') {
            return $next($request);
        }

        $publicRoot = realpath(public_path());

        if ($publicRoot === false) {
            return $next($request);
        }

        $candidate = public_path($relativePath);
        $attempts = 0;

        while ($attempts < 5) {
            clearstatcache(true, $candidate);

            $resolved = realpath($candidate);

            if ($resolved !== false && $this->isFileInsidePublicRoot($resolved, $publicRoot)) {
                return new BinaryFileResponse($resolved);
            }

            $attempts++;
            usleep(2000);
        }

        return $next($request);
    }

    private function isFileInsidePublicRoot(string $resolvedPath, string $publicRoot): bool
    {
        if (! is_file($resolvedPath)) {
            return false;
        }

        $prefix = $publicRoot.DIRECTORY_SEPARATOR;

        return str_starts_with($resolvedPath, $prefix);
    }
}
