#!/bin/bash

GITCC_DIR=$(dirname "$(echo "$0" | sed -e 's,\\,/,g')")
. "$GITCC_DIR/lib/common"

load_library "application"
