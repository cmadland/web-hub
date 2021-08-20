const path = require('path');
const process = require('process');
const colors = require('tailwindcss/colors');
const dirname = process.env.PWD || process.cwd();
const normalize = (paths) => {
  return paths.map((_path) => path.normalize(`${dirname}/${_path}`));
}

module.exports = {
  mode: 'jit',
  purge: {
    content: normalize([
      '../../config/**/*.yaml',
      '../../pages/**/*.md',
      './blueprints/**/*.yaml',
      './js/**/*.js',
      './templates/**/*.twig',
      './typhoon.yaml',
      './typhoon.php',
      './available-classes.md',
    ]),
    options: {
      keyframes: true,
      fontFace: true,
    },
  },
  theme: {
    extend: {
      inset: {
        '2': '0.5rem',
        'full': '100%',
        '1/2': '50%',
        '-1/2': '-50%',
        'inherit': 'inherit'
      },
      fontFamily: {
        sans: [
          'Inter var',
          '-apple-system',
          'BlinkMacSystemFont',
          '"Segoe UI"',
          'Roboto',
          '"Helvetica Neue"',
          'Arial',
          '"Noto Sans"',
          'sans-serif',
          '"Apple Color Emoji"',
          '"Segoe UI Emoji"',
          '"Segoe UI Symbol"',
          '"Noto Color Emoji"',
        ],
      },
      width: {
        'content': 'max-content',
      },
      maxHeight: {
        '0': '0',
      },
      lineHeight: {
        'tighter': '1.15',
      },
      strokeWidth: {
        '3/2': '1.5',
        '5/2': '2.5',
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: 'inherit',
            lineHeight: 'inherit',
            maxWidth: 'inherit',
            a: {
              transition: 'all 500ms',
              color: theme('colors.primary.DEFAULT'),
              '&:hover': {
                color: theme('colors.primary.darker')
              },
              textDecoration: 'none'
            },
            strong: {
              color: 'inherit'
            },
            code: {
              backgroundColor: theme('colors.gray.100'),
              color: theme('colors.indigo.600'),
              fontWeight: 'inherit'
            },
            pre: {
              backgroundColor: theme('colors.blue.100'),
              backgroundOpacity: theme('opacity-50'),
              color: theme('colors.blue.800'),
            },
          }
        }
      }),
      colors: {
        orange: colors.orange,
        transparent: 'transparent',
        'inherit': 'inherit',
        'primary': {
          DEFAULT: 'var(--color-primary)',
          'lighter': 'var(--color-primary__lighter)',
          'darker': 'var(--color-primary__darker)',
        },
        'gray': {
          900: '#1B1B1C',
          800: '#222222',
          700: '#2C2C2C',
          600: '#464646',
          500: '#939393',
          400: '#C4C4C4',
          300: '#DFDFDF',
          200: '#EEEEEE',
          100: '#F9F9F9',
        },
      },
    },
    columnCount: [ 1, 2, 3, 4 ],
  },
  variants: {
    extend: {
      filter: ['hover', 'group-hover'],
      brightness: ['hover', 'group-hover'],
      scale: ['hover', 'group-hover'],
      borderWidth: ['last'],
    }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('tailwindcss-multi-column')(),
    require('tailwindcss-debug-screens'),
  ],
  darkMode: 'class',
}