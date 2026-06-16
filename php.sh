#!/usr/bin/env bash
#
# Run PHP (and Composer, which ships in the image) inside a container — there
# is no PHP/Composer on the host. Mirrors the image used by ./test.sh.
#
# Usage:
#   ./php.sh -v                         # php --version
#   ./php.sh artisan ...                # run a php script
#   ./php.sh composer install           # composer is on PATH in the image
#   ./php.sh vendor/bin/pest --filter=x  # ad-hoc tooling (prefer ./test.sh for the suite)
#
# Any arguments are forwarded to the container shell.

set -euo pipefail

IMAGE="mcr.microsoft.com/devcontainers/php:3-8.5-trixie"
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

docker run --rm \
    -v "${PROJECT_DIR}":/app \
    -w /app \
    "${IMAGE}" \
    "$@"
