<?php
namespace OAV;


 add_action('admin_init', array($this, 'admin_init'));
 add_action('admin_menu', array($this, 'add_options_page'));
 
class OAV extends OAV { 
     public function add_options_page() {
        $this->oembed_option_page = add_options_page(__('oEmbed','fau-oembed'),
                __('oEmbed','fau-oembed'), 'manage_options', 'options-oembed',
                array($this, 'options_oembed'));
        add_action('load-' . $this->oembed_option_page, array($this, 'oembed_help_menu'));
    }

    public function oembed_help_menu() {

        $content_overview = array(
            '<p>' . __('WordPress bindet Videos, Bilder und andere Inhalte einiger Provider automatisch in Ihre Blog-Seiten ein, sobald Sie den Link auf die entsprechende Datei angeben. Unterstützt werden hierbei z.B. Daten von YouTube, Twitter und Flickr.','fau-oembed') . '</p>',
            '<p><strong>' . __('Standardwerte für eingebettete Objekte','fau-oembed') . '</strong></p>',
            '<p>' . __('Hier können Sie einstellen, in welcher Größe die Inhalte automatisch eingebunden werden. Bei Objekten, bei denen das Seitenverhältnis fest vorgegeben ist (z.B. Videos), wird hierbei auf die kleinste Größe beschränkt.','fau-oembed') . '</p>',
            '<p>' . __('Sofern Sie die automatische Einbindung von YouTube-Videos ohne Cookies aktiviert haben, werden diese in der hierbei festgelegten Größe angezeigt.','fau-oembed') . '</p>'
        );

        $content_faukarte = array(
            '<p><strong>' . __('Automatische Einbindung von FAU-Karten','fau-oembed') . '</strong></p>',
            '<p>' . __('Die Friedrich-Alexander-Universität Erlangen-Nürnberg bietet die Möglichkeit, Karten von Standorten universitärer Einrichtungen zu erstellen. Sofern Sie hier die automatische Einbindung von diesen FAU-Karten aktivieren, wird Ihnen statt eines Links die Karte in Ihrer Blog-Seite angezeigt.','fau-oembed') . '</p>',
            '<p>' . __('So erstellen Sie Ihre FAU-Karte:','fau-oembed') . '</p>',
            '<ol>',
            '<li>' . sprintf(__('Gehen Sie auf den %s.','fau-oembed'), '<a href="http://karte.fau.de/generator" target="_blank">Kartengenerator der Friedrich-Alexander-Universität Erlangen-Nürnberg</a>') . '</li>',
            '<li>' . __('Geben Sie den Standort der FAU an, den Sie in Ihrer Karte anzeigen möchten.','fau-oembed') . '</li>',
            '<li>' . __('Klicken Sie auf <i>Abschicken</i>.','fau-oembed') . '</li>',
            '<li>' . __('Kopieren Sie den angezeigten direkten Link zum iFrame und geben Sie diesen auf Ihrer Blog-Seite an.','fau-oembed') . '</li>',
            '</ol>',
            '<p><strong>' . __('Einbindung von FAU-Karten über Shortcode','fau-oembed') . '</strong></p>',
            '<p>' . __('Alternativ kann eine Karte von http://karte.fau.de auch über den Shortcode [faukarte] mit folgenden Parametern eingebunden werden:','fau-oembed') . '</p>',
            '<ol>',
            '<li>' . sprintf(__('url: Adresse des anzuzeigenden Kartenausschnitts, ohne vorangestelltes %1$s. Hier können Sie auch direkt die URL des gewählten Kartenausschnittes ohne vorangestelltes %2$s verwenden.','fau-oembed'), 'https://karte.fau.de/api/v1/iframe/', 'https://karte.fau.de/') . '</li>',
            '<li>' . __('width: Breite des anzuzeigenden Kartenausschnitts (auch %-Angaben sind erlaubt).','fau-oembed') . '</li>',
            '<li>' . __('height: Höhe des anzuzeigenden Kartenausschnitts (auch %-Angaben sind erlaubt).','fau-oembed') . '</li>',
            '<li>' . __('zoom: Zoomfaktor für den anzuzeigenden Kartenausschnitt (Wert zwischen 1 und 19, je größer der Wert desto größer die Darstellung).','fau-oembed') . '</li>',
            '<li>' . __('Beispiel: [faukarte url="address/martensstraße 1" width="100%" height="100px" zoom="12"]','fau-oembed') . '</li>',
            '</ol>',
        );

        $content_fauvideo = array(
            '<p><strong>' . __('Automatische Einbindung des FAU Videoportals','fau-oembed') . '</strong></p>',
            '<p>' . __('Wenn Sie hier die automatische Einbindung des FAU Videoportals aktivieren, wird Ihnen statt des Links der Clip in Ihrer Blog-Seite angezeigt.','fau-oembed') . '</p>',
            '<p>' . __('So binden Sie einen Clip des Videoportals ein:','fau-oembed') . '</p>',
            '<ol>',
            '<li>' . sprintf(__('Gehen Sie auf das %s.','fau-oembed'), '<a href="http://www.video.uni-erlangen.de/" target="_blank">Videoportal der Friedrich-Alexander-Universität Erlangen-Nürnberg</a>') . '</li>',
            '<li>' . __('Wählen Sie das Video aus, das Sie in Ihrem Blog anzeigen möchten.','fau-oembed') . '</li>',
            '<li>' . __('Kopieren Sie die Adresse des <i>Anschauen</i>-Links des Videos.','fau-oembed') . '</li>',
            '<li>' . __('Fügen Sie die kopierte Adresse auf Ihrer Seite ein.','fau-oembed') . '</li>',
            '</ol>'
        );

        $content_youtube_nocookie = array(
            '<p><strong>' . __('Automatische Einbindung von YouTube-Videos ohne Cookies','fau-oembed') . '</strong></p>',
            '<p>' . sprintf(__('Wenn Sie hier die automatische Einbindung von YouTube-Videos ohne Cookies aktivieren, wird Ihnen bei der Angabe eines Links zu einem Video von der Seite %s','fau-oembed'), '<a href="http://www.youtube.de/" target="_blank">YouTube</a>') . '</p>',
            '<ol>',
            '<li>' . __('auf Ihrer Blog-Seite das YouTube-Video ohne die Verwendung von Cookies und','fau-oembed') . '</li>',
            '<li>' . __('zusätzlich noch der Link zu dem Video auf YouTube angezeigt.','fau-oembed') . '</li>',
            '</ol>',
            '<p>' . __('Dabei können Sie die Breite angeben, in der YouTube-Videos auf Ihrer Seite dargestellt werden.','fau-oembed') . '</p>',
            '<p>' . __('Wenn Sie die Option <i>Anzeige ähnlicher Videos ausblenden</i> aktivieren, werden Ihnen am Ende Ihres Videos keine ähnlichen Videos als Vorschau angezeigt.','fau-oembed') . '</p>',
        );

        $help_tab_overview = array(
            'id' => 'overview',
            'title' => __('Übersicht','fau-oembed'),
            'content' => implode(PHP_EOL, $content_overview),
        );

        $help_tab_faukarte = array(
            'id' => 'faukarte',
            'title' => __('FAU-Karte','fau-oembed'),
            'content' => implode(PHP_EOL, $content_faukarte),
        );

        $help_tab_fauvideo = array(
            'id' => 'fauvideo',
            'title' => __('FAU Videoportal','fau-oembed'),
            'content' => implode(PHP_EOL, $content_fauvideo),
        );

        $help_tab_youtube_nocookie = array(
            'id' => 'youtube_nocookie',
            'title' => __('YouTube ohne Cookies','fau-oembed'),
            'content' => implode(PHP_EOL, $content_youtube_nocookie),
        );

        $help_sidebar = __('<p><strong>Für mehr Information:</strong></p><p><a href="http://blogs.fau.de/webworking">RRZE-Webworking</a></p><p><a href="https://github.com/RRZE-Webteam">RRZE-Webteam in Github</a></p>','fau-oembed');

        $screen = get_current_screen();

        if ($screen->id != $this->oembed_option_page) {
            return;
        }

        $screen->add_help_tab($help_tab_overview);
        $screen->add_help_tab($help_tab_faukarte);
        $screen->add_help_tab($help_tab_fauvideo);
        $screen->add_help_tab($help_tab_youtube_nocookie);

        $screen->set_help_sidebar($help_sidebar);
    }

    public function options_oembed() {
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php echo esc_html(__('Einstellungen &rsaquo; oEmbed','fau-oembed')); ?></h2>

            <form method="post" action="options.php">
                <?php
                settings_fields('oembed_options');
                do_settings_sections('oembed_options');
                submit_button();
                ?>
            </form>            
        </div>
        <?php
    }

    public function admin_init() {

        register_setting('oembed_options', self::option_name, array($this, 'options_validate'));

        add_settings_section('embed_default_section', __('Standardwerte für eingebettete Objekte','fau-oembed'), '__return_false', 'oembed_options');

        add_settings_field('embed_defaults_width', __('Breite','fau-oembed'), array($this, 'embed_defaults_width'), 'oembed_options', 'embed_default_section');
        add_settings_field('embed_defaults_height', __('Höhe','fau-oembed'), array($this, 'embed_defaults_height'), 'oembed_options', 'embed_default_section');

        add_settings_section('faukarte_section', __('Automatische Einbindung von FAU-Karten','fau-oembed'), '__return_false', 'oembed_options');
        add_settings_field('faukarte_active', __('Aktivieren','fau-oembed'), array($this, 'faukarte_active'), 'oembed_options', 'faukarte_section');

        add_settings_section('videoportal_section', __('Automatische Einbindung des FAU Videoportals','fau-oembed'), '__return_false', 'oembed_options');
        add_settings_field('videoportal_active', __('Aktivieren','fau-oembed'), array($this, 'videoportal_active'), 'oembed_options', 'videoportal_section');

        add_settings_section('youtube_nocookie_section', __('Automatische Einbindung von YouTube-Videos ohne Cookies','fau-oembed'), '__return_false', 'oembed_options');
        add_settings_field('youtube_nocookie_active', __('Aktivieren','fau-oembed'), array($this, 'youtube_nocookie_active'), 'oembed_options', 'youtube_nocookie_section');
        add_settings_field('youtube_nocookie_width', __('Breite','fau-oembed'), array($this, 'youtube_nocookie_width'), 'oembed_options', 'youtube_nocookie_section');
        add_settings_field('youtube_nocookie_norel', __('Anzeige ähnlicher Videos ausblenden','fau-oembed'), array($this, 'youtube_nocookie_norel'), 'oembed_options', 'youtube_nocookie_section');
    }

    public function embed_defaults_width() {
        $options = $this->get_options();
        ?>
        <input type='text' name="<?php printf('%s[embed_defaults][width]', self::option_name); ?>" value="<?php echo $options['embed_defaults']['width']; ?>">
        <?php
    }

    public function embed_defaults_height() {
        $options = $this->get_options();
        ?>
        <input type='text' name="<?php printf('%s[embed_defaults][height]', self::option_name); ?>" value="<?php echo $options['embed_defaults']['height']; ?>">
        <?php
    }

    public function faukarte_active() {
        $options = $this->get_options();
        ?>
        <input type='checkbox' name="<?php printf('%s[faukarte][active]', self::option_name); ?>" <?php checked($options['faukarte']['active'], true); ?>>                   
        <?php
    }

    public function videoportal_active() {
        $options = $this->get_options();
        ?>
        <input type='checkbox' name="<?php printf('%s[fau_videoportal]', self::option_name); ?>" <?php checked($options['fau_videoportal'], true); ?>>
        <?php
    }

    public function youtube_nocookie_active() {
        $options = $this->get_options();
        ?>
        <input type='checkbox' name="<?php printf('%s[youtube_nocookie][active]', self::option_name); ?>" <?php checked($options['youtube_nocookie']['active'], true); ?>>
        <?php
    }

    public function youtube_nocookie_width() {
        $options = $this->get_options();
        ?>
        <input type='text' name="<?php printf('%s[youtube_nocookie][width]', self::option_name); ?>" value="<?php echo $options['youtube_nocookie']['width']; ?>">
        <p class="description"><?php _e('Zu empfehlen ist eine Breite von mindestens 350px.','fau-oembed'); ?></p>
        <?php
    }

    public function youtube_nocookie_norel() {
        $options = $this->get_options();
        ?>
        <input type='checkbox' name="<?php printf('%s[youtube_nocookie][norel]', self::option_name); ?>"<?php checked($options['youtube_nocookie']['norel'], true); ?>>
        <p class="description"><?php _e('Funktioniert nur, wenn die automatische Einbindung von YouTube-Videos aktiviert ist.','fau-oembed'); ?></p>
        <?php
    }

    public function options_validate($input) {
        $defaults = $this->default_options();
        $options = $this->get_options();

        $input['embed_defaults']['width'] = (int) $input['embed_defaults']['width'];
        $input['embed_defaults']['height'] = (int) $input['embed_defaults']['height'];
        $input['embed_defaults']['width'] = !empty($input['embed_defaults']['width']) ? $input['embed_defaults']['width'] : $defaults['embed_defaults']['width'];
        $input['embed_defaults']['height'] = !empty($input['embed_defaults']['height']) ? $input['embed_defaults']['height'] : $defaults['embed_defaults']['height'];

        $input['faukarte']['active'] = isset($input['faukarte']['active']) ? true : false;
        $input['fau_videoportal'] = isset($input['fau_videoportal']) ? true : false;

        $input['youtube_nocookie']['active'] = isset($input['youtube_nocookie']['active']) ? true : false;
        $input['youtube_nocookie']['norel'] = isset($input['youtube_nocookie']['norel']) ? 1 : 0;
        $input['youtube_nocookie']['width'] = (int) $input['youtube_nocookie']['width'];
        $input['youtube_nocookie']['width'] = !empty($input['youtube_nocookie']['width']) ? $input['youtube_nocookie']['width'] : $defaults['youtube_nocookie']['width'];
        return $input;
    }
}