<?php
class Icons {
    private static function base($width, $height, $class, $svgContent, $strokeWidth = 2, $strokeColor = 'currentColor') {
        return '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" viewBox="0 0 24 24" fill="none" stroke="'.$strokeColor.'" stroke-width="'.$strokeWidth.'" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-top:-2px;">'.$svgContent.'</svg>';
    }

    public static function home($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>');
    }

    public static function check($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<polyline points="20 6 9 17 4 12"/>');
    }

    public static function cross($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>');
    }

    public static function warning($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>');
    }

    public static function mail($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>');
    }

    public static function search($size = 16, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>', 2.5);
    }

    public static function user($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>');
    }

    public static function users($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>');
    }

    public static function plus($size = 16, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>', 2.5);
    }

    public static function edit($size = 14, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>', 2.5);
    }

    public static function delete($size = 14, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>', 2.5);
    }

    public static function ticket($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 11v2"/><path d="M13 17v2"/>');
    }

    public static function dashboard($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>');
    }

    public static function logout($size = 16, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>');
    }

    public static function bed($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 14h20"/><path d="M6 8v4"/><circle cx="10" cy="11" r="1"/>');
    }

    public static function gear($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>');
    }

    public static function eye($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>');
    }

    public static function pin($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>');
    }

    public static function shield($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>');
    }

    public static function wave($size = 24, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v5"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v6"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M6 14v-1.5a1.5 1.5 0 0 0-3 0V18a6 6 0 0 0 6 6h4a10 10 0 0 0 10-10v-2.5a1.5 1.5 0 0 0-3 0V12"/>');
    }

    public static function lightbulb($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .5 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/>');
    }

    public static function clock($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>');
    }

    public static function fire($size = 18, $class = 'icon-svg') {
        return self::base($size, $size, $class, '<path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>');
    }
}
?>
