exports.config =
  paths:
    watched: ['app']
  files:
    stylesheets:
      joinTo:
        'css/adhoc.css': /^app\/styles\/adhoc.styl/
  plugins:
    postcss:
      options:
        relative: true
      processors: [
        # permet inline() en css
        require('postcss-assets')
        require('autoprefixer')(['last 3 versions'])
      ]
