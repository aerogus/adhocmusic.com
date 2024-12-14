import js from "@eslint/js";

export default [
    js.configs.recommended,
    {
        ignores: [
            "public/static/library/*",
            "vendor/*"
        ]
    },
    {
        rules: {
            "no-unused-vars": "error",
            "no-undef": "error"
        }
    }
];

