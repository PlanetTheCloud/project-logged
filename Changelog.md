# Critical notes
- Do not override SESSION's `_csrf` key.
- `auth/*` path belongs to LOGGED.
- Some error messages are obscured. Enable Developer Mode to show the true error message.

# v2.2
- Changed signup mechanism to submit the parameter via user's browser.
- The log file for when token is missing during signup has changed from `APP/cache/logs.txt` to `APP/logs/missing_tokens.txt`.
