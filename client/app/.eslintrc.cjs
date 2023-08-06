module.exports = {
  root: true,
  env: {
    node: true
  },
  extends: [
    'plugin:vue/vue3-essential',
    '@vue/typescript/recommended',
    'prettier',
    'plugin:prettier/recommended'
  ],
  parserOptions: {
    ecmaVersion: 2020
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    '@typescript-eslint/no-unused-vars': 'error',
    'vue/component-definition-name-casing': ['error', 'PascalCase'],
    'vue/multi-word-component-names': 'off',
    'prettier/prettier': [
      'error',
      {
        singleQuote: true,
        semi: true,
        trailingComma: 'none',
        bracketSpacing: true,
        jsxBracketSameLine: false,
        arrowParens: 'avoid',
        endOfLine: 'auto',
        printWidth: 80
      }
    ]
  }
};
