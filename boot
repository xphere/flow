#!/bin/bash

boot() {
	GITCC_DIR=$(script_dir)
	. "$GITCC_DIR/lib/common"

	load_library "application"
}

script_dir() {
    local SOURCE="${@:-${BASH_SOURCE[0]}}"
    echo $(cd $(dirname "$SOURCE") && pwd)
}

boot
