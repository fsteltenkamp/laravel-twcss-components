#!/usr/bin/env bash
#
# Run the Pest suite inside a PHP container (no PHP/Composer on the host).
#
# Usage:
#   ./test.sh                                  # install deps + run the full suite
#   ./test.sh tests/BladeRenderTest.php        # one test file
#   ./test.sh --filter="floating table"        # one test by name
#
# Any arguments are forwarded to vendor/bin/pest.

set -euo pipefail

IMAGE="mcr.microsoft.com/devcontainers/php:3-8.5-trixie"
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

docker run --rm \
    -v "${PROJECT_DIR}":/app \
    -w /app \
    "${IMAGE}" \
    bash -lc 'composer install -q --no-interaction && vendor/bin/pest "$@"' _ "$@"
