import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/**
 * Helper agar Tailwind mendukung CSS Custom Properties (var(--waris-*))
 * lengkap dengan modifier transparansi (misal: bg-waris-primary/10).
 */
const cssVar = (variable) => ({ opacityValue }) => {
    if (opacityValue !== undefined) {
        return `color-mix(in srgb, var(${variable}) calc(${opacityValue} * 100%), transparent)`;
    }
    return `var(${variable})`;
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                waris: {
                    primary: cssVar('--waris-primary'),
                    'primary-hover': cssVar('--waris-primary-hover'),
                    'primary-active': cssVar('--waris-primary-active'),
                    'primary-soft': cssVar('--waris-primary-soft'),
                    'primary-border': cssVar('--waris-primary-border'),
                    'primary-muted': cssVar('--waris-primary-muted'),

                    accent: cssVar('--waris-accent'),
                    'accent-hover': cssVar('--waris-accent-hover'),
                    'accent-active': cssVar('--waris-accent-active'),
                    'accent-soft': cssVar('--waris-accent-soft'),
                    'accent-border': cssVar('--waris-accent-border'),
                    'accent-text': cssVar('--waris-accent-text'),

                    barter: cssVar('--waris-barter'),
                    'barter-hover': cssVar('--waris-barter-hover'),
                    'barter-soft': cssVar('--waris-barter-soft'),
                    'barter-border': cssVar('--waris-barter-border'),
                    'barter-text': cssVar('--waris-barter-text'),

                    bg: cssVar('--waris-bg'),
                    surface: cssVar('--waris-surface'),
                    'surface-muted': cssVar('--waris-surface-muted'),
                    'surface-hover': cssVar('--waris-surface-hover'),
                    border: cssVar('--waris-border'),
                    'border-strong': cssVar('--waris-border-strong'),

                    text: cssVar('--waris-text'),
                    'text-secondary': cssVar('--waris-text-secondary'),
                    muted: cssVar('--waris-text-muted'),
                    subtle: cssVar('--waris-text-subtle'),
                    faint: cssVar('--waris-text-faint'),

                    danger: cssVar('--waris-danger'),
                    'danger-hover': cssVar('--waris-danger-hover'),
                    'danger-soft': cssVar('--waris-danger-soft'),
                    'danger-border': cssVar('--waris-danger-border'),
                    'danger-text': cssVar('--waris-danger-text'),

                    info: cssVar('--waris-info'),
                    'info-soft': cssVar('--waris-info-soft'),
                    'info-border': cssVar('--waris-info-border'),
                    'info-text': cssVar('--waris-info-text'),
                },
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            }
        },
    },

    plugins: [forms],
};
