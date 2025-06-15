#!/bin/bash

# Get the root directory of the project regardless of where the script is run from
ROOT_DIR="$(cd "$(dirname "$0")/../.." && pwd)"

# Activate virtual environment
# Linux/macOS/WSL
if [[ "$OSTYPE" == "linux-gnu"* || "$OSTYPE" == "darwin"* || "$OSTYPE" == "msys"* || "$OSTYPE" == "cygwin" ]]; then
    source "$ROOT_DIR/.venv/bin/activate"
# Windows Git Bash (fallback)
elif [[ -f "$ROOT_DIR/.venv/Scripts/activate" ]]; then
    source "$ROOT_DIR/.venv/Scripts/activate"
else
    echo "Could not find a compatible Python virtual environment activation script."
    exit 1
fi

# Run Python script (default to test.py)
SCRIPT_NAME=${1:-test.py}
SCRIPT_PATH="$ROOT_DIR/skycloud/src/$SCRIPT_NAME"

if [[ -f "$SCRIPT_PATH" ]]; then
    python "$SCRIPT_PATH"
else
    echo "Script $SCRIPT_PATH not found."
    exit 1
fi
