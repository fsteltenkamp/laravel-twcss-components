#!/usr/bin/env bash
#
# Run the Pest suite
#
# Usage:
#   ./test.sh                                  # run the full suite
#   ./test.sh tests/BladeRenderTest.php        # one test file
#   ./test.sh --filter="floating table"        # one test by name
#
# Any arguments are forwarded to vendor/bin/pest.

vendor/bin/pest "$@"
