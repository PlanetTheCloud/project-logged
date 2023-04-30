- Improved Session Security
- Cleanup unused memory
- Added maintenance mode and maintenance key to access the site during maintenance
- Too much to add and I'm kinda lazy

Notes for improvements:
- Some code can be refactored however they're just not that worth it to do

Critical notes:
- Reserve SESSION _tokens key
- Reserve anything under /auth
- Not all error messages tell the truth. Use dev mode to spit the truth out