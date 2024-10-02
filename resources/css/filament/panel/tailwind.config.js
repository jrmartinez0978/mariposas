import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/js/**/*.js', // Añade esta línea si usas Tailwind en archivos JS
        './resources/vue/**/*.vue', // Añade esta línea si usas Tailwind en archivos Vue
        '<path-to-vendor>/awcodes/overlook/resources/**/*.blade.php',
    ],
    
}
