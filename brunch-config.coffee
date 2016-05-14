exports.config =
  paths:
    watched: ['app']
  modules:
    definition: false
    wrapper: false
  files:
    stylesheets:
      joinTo:
        'css/adhoc.css': /^app\/styles\/adhoc.styl/
  plugins:
    # à n'exécuter qu'une fois
    afterBrunch: [
      #'unlink ./public/media && ln -s ../media ./public/media',
      #'unlink ./public/img/cache && ln -s ../../cache/img ./public/img/cache'
    ]
    postcss:
      processors: [
        # permet inline() en css
        require('postcss-assets')
        require('autoprefixer')(['last 6 versions'])
      ]

