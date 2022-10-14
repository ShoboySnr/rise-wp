<?php

namespace RiseWP\Api;


use RiseWP\Classes\Opportunities;
use RiseWP\Classes\ToolResources;
use RiseWP\Classes\Utilities;
use RiseWP\Classes\Webinars;
use RiseWP\Classes\Knowledge;
use RiseWP\Classes\OpportunitiesBanner;



class Develop {

    public $opportunity_categories = RISE_WP_OPPORTUNITIES_CAT;
    public $opportunity_types = RISE_WP_OPPORTUNITIES_TYPES;

    public $tools_resources_categories = RISE_WP_TOOLSRESOURCES_CAT;
    public $tools_resources_types = RISE_WP_TOOLSRESOURCES_TYPES;



    public $knowledge_categories = RISE_WP_KNOWLEDGE_CAT;
    public $knowledge_types = RISE_WP_KNOWLEDGE_TYPE;
//    public $panels;

    public function __construct()
    {
        add_shortcode('rise_develop_innovation_audits', [$this, 'rise_develop_innovation_audits']);
        add_shortcode('rise_develop_knowledge_and_research', [$this, 'rise_develop_knowledge_and_research']);
        add_shortcode('rise_develop_opportunities', [$this, 'rise_develop_opportunities']);

        add_shortcode('rise_wp_tools_and_resources_overview', [$this, 'rise_wp_tools_and_resources_overview']);
        add_shortcode('rise_wp_tools_and_resources', [$this, 'rise_wp_tools_and_resources']);

        add_shortcode('rise_wp_tools_and_resources_webinars', [$this, 'rise_wp_tools_and_resources_webinars']);


        add_action('wp_ajax_rise_wp_update_opportunities_submission', [$this, 'rise_wp_update_opportunities_submission']);

    }

    public function rise_develop_innovation_audits() {
        $page = get_page_by_path('develop/innovation-audits');

        $page_title = $page->post_title;

        $about_the_rise_innovation_title = get_field('about_the_rise_innovation_title');
        $about_the_rise_innovation = get_field('about_the_rise_innovation');
        $rise_innovation_step_one_title = get_field('rise_innovation_step_one_title');
        $rise_innovation_step_one = get_field('rise_innovation_step_one');
        $rise_innovation_step_two_title = get_field('rise_innovation_step_two_title');
        $rise_innovation_step_two = get_field('rise_innovation_step_two');
        $rise_innovation_step_three_title = get_field('rise_innovation_step_three_title');
        $rise_innovation_step_three = get_field('rise_innovation_step_three');
        $rise_innovation_step_three_button_link = get_field('rise_innovation_step_three_button_link');
        $sample_report_download = get_field('sample_report_download');


        $msg = '<div class="pt-16 pb-40">';
        $msg .= '<h4 class="text-2xl font-semibold text-riseDark mb-9">'.$page_title.'</h4>';
        $msg .= '<div class="rounded-xl border border-gray350 overflow-hidden">';
        $msg .= '<h4 class="rounded-t-xl text-xl sm:text-2xl font-semibold text-white bg-riseDark p-4 sm:px-8 sm:py-10">'. $about_the_rise_innovation_title .'</h4>';
        $msg .= '<div class="rounded-b-xl border-r border-l border-b border-gray350 p-4 sm:px-8 sm:py-10 bg-white" style="font-weight: 400; line-height: 24px; font-size: 16px"><div class="">'.$about_the_rise_innovation.'</div></div>';
        $msg .= '</div>';

        $msg .= '<div class="mt-10">';
        $msg .= '<div class="rounded-t-xl overflow-hidden flex justify-between items-center text-white bg-red300 p-4 sm:px-8 sm:py-10">';
        $msg .= '<h4 class="text-xl sm:text-2xl font-semibold">'.$rise_innovation_step_one_title.'</h4>';
        $msg .= '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M27.7902 11.1579C25.306 8.92633 21.9376 7.83158 18.5691 8.21053C13.1796 8.80001 8.80068 13.1369 8.16909 18.4843C7.62172 22.9475 9.60068 27.2843 13.306 29.7685C13.8533 30.1475 14.1902 30.737 14.1902 31.3685V36.5475C14.1902 37.2633 14.4849 37.8949 15.0323 38.3581L16.3376 39.4528C16.7586 39.7896 17.306 40.0002 17.8534 40.0002H21.9376C22.485 40.0002 23.0323 39.7896 23.4534 39.4528L24.7586 38.3581C25.306 37.8949 25.6008 37.2633 25.6008 36.5475V31.4107C25.6008 30.737 25.8955 30.1475 26.4008 29.8106C29.7271 27.6212 31.7061 23.9159 31.7061 19.9159C31.7482 16.5895 30.3166 13.3895 27.7902 11.1579ZM16.4218 31.6212H23.4534V33.558H16.4218V31.6212ZM23.3692 36.6738L22.0639 37.7686C22.0218 37.8107 21.9797 37.8107 21.9376 37.8107H17.8534C17.8112 37.8107 17.7691 37.8107 17.727 37.7686L16.4218 36.6738C16.3797 36.6317 16.3797 36.5896 16.3797 36.5475V35.7475H23.4113V36.5475C23.4113 36.5896 23.4113 36.6738 23.3692 36.6738ZM25.2218 28.0001C24.6744 28.3791 24.2534 28.8422 23.9165 29.3896H15.8744C15.5376 28.8001 15.1165 28.337 14.527 27.958C11.4954 25.9369 9.89542 22.4001 10.3165 18.7369C10.8638 14.3579 14.4007 10.8632 18.7797 10.3579C19.2007 10.3158 19.5797 10.3158 19.9165 10.3158C22.3165 10.3158 24.5481 11.1579 26.3166 12.7579C28.3376 14.5685 29.5166 17.2211 29.5166 19.958C29.5587 23.2001 27.9166 26.2317 25.2218 28.0001Z"
                  fill="white" />
                <path
                  d="M19.916 5.76845C20.5055 5.76845 21.0108 5.26318 21.0108 4.67371V1.09474C21.0108 0.505266 20.5055 0 19.916 0C19.3266 0 18.8213 0.505266 18.8213 1.09474V4.67371C18.8213 5.26318 19.2844 5.76845 19.916 5.76845Z"
                  fill="white" />
                <path
                  d="M11.3261 7.28487C11.5366 7.62172 11.9156 7.83224 12.2945 7.83224C12.463 7.83224 12.6735 7.79014 12.8419 7.70593C13.3472 7.41119 13.5577 6.7375 13.263 6.19013L11.4524 3.07432C11.1577 2.56906 10.484 2.35853 9.93663 2.65327C9.43136 2.94801 9.22084 3.6217 9.51557 4.16907L11.3261 7.28487Z"
                  fill="white" />
                <path
                  d="M3.07335 11.4524L6.18916 13.263C6.35758 13.3472 6.56811 13.3893 6.73653 13.3893C7.11548 13.3893 7.49443 13.1788 7.70495 12.8419C7.99969 12.3366 7.83127 11.663 7.2839 11.3261L4.16809 9.51558C3.66283 9.22084 2.98914 9.38926 2.6523 9.93663C2.35756 10.484 2.52598 11.1577 3.07335 11.4524Z"
                  fill="white" />
                <path
                  d="M5.76845 19.916C5.76845 19.3266 5.26318 18.8213 4.67371 18.8213H1.09474C0.505266 18.8213 0 19.3266 0 19.916C0 20.5055 0.505266 21.0108 1.09474 21.0108H4.67371C5.26318 21.0108 5.76845 20.5476 5.76845 19.916Z"
                  fill="white" />
                <path
                  d="M6.19013 26.6109L3.07432 28.3793C2.56906 28.674 2.35853 29.3477 2.65327 29.8951C2.8638 30.2319 3.24275 30.4425 3.6217 30.4425C3.79012 30.4425 4.00065 30.4003 4.16907 30.3161L7.28487 28.5056C7.79014 28.2109 8.00066 27.5372 7.70593 26.9898C7.36908 26.4845 6.69539 26.3161 6.19013 26.6109Z"
                  fill="white" />
                <path
                  d="M36.7575 28.3788L33.6417 26.5683C33.1365 26.2736 32.4628 26.442 32.1259 26.9894C31.8312 27.4946 31.9996 28.1683 32.547 28.5052L35.6628 30.3157C35.8312 30.3999 36.0417 30.442 36.2102 30.442C36.5891 30.442 36.9681 30.2315 37.1786 29.8946C37.4733 29.3473 37.3049 28.6736 36.7575 28.3788Z"
                  fill="white" />
                <path
                  d="M38.7372 18.8213H35.1582C34.5687 18.8213 34.0635 19.3266 34.0635 19.916C34.0635 20.5055 34.5687 21.0108 35.1582 21.0108H38.7372C39.3267 21.0108 39.8319 20.5055 39.8319 19.916C39.8319 19.3266 39.3267 18.8213 38.7372 18.8213Z"
                  fill="white" />
                <path
                  d="M33.0953 13.3893C33.2638 13.3893 33.4743 13.3472 33.6427 13.263L36.7585 11.4524C37.2638 11.1577 37.4743 10.484 37.1796 9.93663C36.8848 9.43136 36.2111 9.22084 35.6638 9.51557L32.548 11.3261C32.0427 11.6208 31.8322 12.2945 32.1269 12.8419C32.3795 13.1788 32.7164 13.3893 33.0953 13.3893Z"
                  fill="white" />
                <path
                  d="M26.9894 7.66394C27.1578 7.74815 27.3683 7.79025 27.5367 7.79025C27.9157 7.79025 28.2946 7.57973 28.5052 7.24288L30.3157 4.12708C30.6104 3.62181 30.442 2.94813 29.8946 2.61128C29.3894 2.31654 28.7157 2.48497 28.3788 3.03234L26.5683 6.14814C26.2736 6.69551 26.442 7.3692 26.9894 7.66394Z"
                  fill="white" />
              </svg>';
        $msg .= '</div>';
        $msg .= '<div class="rounded-b-xl border-l border-r border-b border-gray350 overflow-hidden p-4 sm:px-8 sm:py-10 bg-white">';
        $msg .= ' <div class="">'.$rise_innovation_step_one.'</div>';

        $msg .= '<div class="flex mt-10 flex-col lg:flex-row justify-between">';

        if(!empty($sample_report_download)) {
            $msg .= '<div class="mb-10 lg:mb-0 lg:mr-9 w-full">';
            $msg .= '<h4 class="text-2xl font-semibold mb-7">' . __('Download an example report', 'rise-wp-theme') . '</h4>';
            $msg .= '<div class="">';
            $msg .= '<div class="rounded-t-xl w-full bg-yellow50 flex justify-center items-center h-48">';
            $msg .= '<svg class="" width="46" height="54" viewBox="0 0 46 54" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M14.8017 38.7062H29.1647C30.2472 38.7062 31.1449 37.7995 31.1449 36.7062C31.1449 35.6128 30.2472 34.7328 29.1647 34.7328H14.8017C13.7191 34.7328 12.8215 35.6128 12.8215 36.7062C12.8215 37.7995 13.7191 38.7062 14.8017 38.7062ZM23.7257 21.3995H14.8017C13.7191 21.3995 12.8215 22.3062 12.8215 23.3995C12.8215 24.4928 13.7191 25.3728 14.8017 25.3728H23.7257C24.8083 25.3728 25.7059 24.4928 25.7059 23.3995C25.7059 22.3062 24.8083 21.3995 23.7257 21.3995ZM42.5679 19.068C43.1885 19.0608 43.8642 19.053 44.4782 19.053C45.1383 19.053 45.6663 19.5863 45.6663 20.253V41.693C45.6663 48.3063 40.3594 53.6663 33.8116 53.6663H12.7951C5.93037 53.6663 0.333008 48.0397 0.333008 41.1063V12.3597C0.333008 5.74634 5.66634 0.333008 12.2406 0.333008H26.3396C27.0261 0.333008 27.5541 0.893008 27.5541 1.55967V10.1463C27.5541 15.0263 31.5409 19.0263 36.3726 19.053C37.5012 19.053 38.4961 19.0614 39.3669 19.0688C40.0443 19.0746 40.6465 19.0797 41.1779 19.0797C41.5537 19.0797 42.0409 19.0741 42.5679 19.068ZM43.2959 15.1753C41.1256 15.1833 38.5672 15.1753 36.7269 15.1566C33.8068 15.1566 31.4015 12.7273 31.4015 9.77795V2.74861C31.4015 1.59928 32.7824 1.02861 33.5718 1.85795C35.0004 3.35816 36.9633 5.42019 38.9175 7.47295C40.8676 9.52149 42.8089 11.5608 44.2015 13.0233C44.9725 13.8313 44.4075 15.1726 43.2959 15.1753Z"
                          fill="#2D2D2D" />
                      </svg>';
            $msg .= '</div>';
            $msg .= '<div class="rounded-b-xl border-l border-r border-b border-gray350 flex flex-col sm:flex-row items-center py-7 pl-8 pr-12">';
            $msg .= '<p class="text-lg font-semibold mb-4 sm:mb-0">'.__('Innovation audit summary', 'rise-wp-theme').'</p>';
            $msg .= '<a target="_blank" href="'.$sample_report_download['url'].'" class="download-audit flex justify-center items-center rounded-full bg-red sm:ml-7 text-white hover:border hover:border-red hover:text-red hover:bg-white">';
            $msg .= '<svg class="mr-4" width="20" height="19" viewBox="0 0 20 19" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path d="M10.2061 12.9365L10.2061 0.895508" stroke="white" stroke-linecap="round"
                        stroke-linejoin="round" />
                      <path d="M13.1221 10.0088L10.2061 12.9368L7.29007 10.0088" stroke="white"
                        stroke-linecap="round" stroke-linejoin="round" />
                      <path
                        d="M14.8391 5.62793H15.7721C17.8071 5.62793 19.4561 7.27693 19.4561 9.31293V14.1969C19.4561 16.2269 17.8111 17.8719 15.7811 17.8719L4.64106 17.8719C2.60606 17.8719 0.956055 16.2219 0.956055 14.1869V9.30193C0.956055 7.27293 2.60205 5.62793 4.63105 5.62793H5.57305"
                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>';
            $msg .= '<span class="ml-0.5">'.__('Download', 'rise-wp-theme').'</span></a>';
            $msg .= '</div></div></div>';
        }

        $msg .= '<div class="w-full text-center">';
        $msg .= '<h4 class="text-2xl font-semibold mb-7 text-left">'.__('Contact us to book an innovation audit', 'rise-wp-theme').'</h4>';
        $msg .= '<div class="rounded-xl border border-gray350 py-7">';
        $msg .= '<div>';
        $msg .= '<img class="rounded-full dashboard-team-img-2 object-cover inline-block" src="'.RISE_THEME_ASSETS_IMAGES_DIR.'/image2.jpeg"  alt="'.__('Rise Team', 'rise-wp-theme').'">';
        $msg .= '<img class="rounded-full dashboard-team-img object-cover inline-block relative border-2 border-white" src="'.RISE_THEME_ASSETS_IMAGES_DIR.'/image1.jpg" alt="'.__('Rise Team', 'rise-wp-theme').'">';
        $msg .= '<img class="rounded-full dashboard-team-img-2 object-cover inline-block" src="'.RISE_THEME_ASSETS_IMAGES_DIR.'/image3.jpg"  alt="'.__('Rise Team', 'rise-wp-theme').'">';
        $msg .= '</div>';
        $msg .= '<p class="text-lg font-semibold mt-6 mb-7">'.__('The RISE Innovation Team', 'rise-wp-theme') .'</p>';
        $msg .= '<button type="button" class="open-contact-modal bg-red innovation-contact flex items-center justify-center text-white rounded-full mx-auto hover:border hover:border-red hover:text-red hover:bg-white" href="javascript:void(0)">'.__('Contact Us', 'rise-wp-theme').'</button>';
        $msg .= '</div></div></div></div></div>';
        $msg .= '<div class="mt-10">';
        $msg .= '<div class="rounded-t-xl flex justify-between items-center text-white bg-red p-4 sm:px-8 sm:py-10">';
        $msg .= '<h4 class="text-xl sm:text-2xl font-semibold">'.$rise_innovation_step_two_title.'</h4>';
        $msg .= '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.9825 28.4535L24.6902 28.1612L24.3482 28.3933C18.3847 32.4399 10.2514 31.8422 4.97148 26.5623C-0.990492 20.6004 -0.990492 10.9334 4.97148 4.97148C10.9334 -0.990492 20.6004 -0.990492 26.5623 4.97148C31.8422 10.2514 32.4399 18.3847 28.3933 24.3482L28.1612 24.6902L28.4535 24.9825L38.7888 35.3178C39.7371 36.266 39.7371 37.8406 38.7888 38.7888C37.8406 39.7371 36.266 39.7371 35.3178 38.7888L24.9825 28.4535ZM23.927 23.927L23.9288 23.9251C28.3854 19.4225 28.4346 12.1585 23.9269 7.65084C19.4216 3.14552 12.1562 3.14552 7.65084 7.65084C3.14552 12.1562 3.14552 19.4216 7.65084 23.9269C12.1562 28.4323 19.4216 28.4323 23.927 23.927Z" fill="white" stroke="#DB3B0F"/>
                    </svg>';
        $msg .= '</div>';
        $msg .= '<div class="rounded-b-xl border-l border-r border-b border-gray350 p-4 sm:px-8 sm:py-10 bg-white">'.$rise_innovation_step_two.'</div>';
        $msg .= '</div>';
        $msg .= '<div class="mt-10">';
        $msg .= '<div class="rounded-t-xl flex justify-between items-center text-white bg-pink p-4 sm:px-8 sm:py-10">';
        $msg .= '<h4 class="text-xl sm:text-2xl font-semibold">'.$rise_innovation_step_three_title.'</h4>';
        $msg .= '<svg width="43" height="40" viewBox="0 0 43 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M40.8556 24.8615C40.8556 24.0507 40.6183 23.2953 40.2113 22.6595C41.3219 21.8868 42.0513 20.5984 42.0513 19.1413C42.0513 16.7842 40.1409 14.8654 37.7932 14.8654H27.8073C28.3568 12.0836 28.6958 8.10684 27.2604 4.78685C26.1725 2.27155 24.6363 0.725864 22.6959 0.194589C19.8278 -0.589376 17.2695 1.24333 17.1633 1.32417C16.8039 1.58722 16.6002 2.01358 16.6233 2.45893L16.9212 8.29595C16.976 9.37049 16.6712 10.4468 16.0627 11.3305L12.8187 16.0406C12.3047 15.3942 11.5143 14.9789 10.6286 14.9789H2.80309C1.25737 14.9789 0 16.2425 0 17.7951V37.1838C0 38.7363 1.25728 40 2.80309 40H10.6286C11.4162 40 12.1284 39.6715 12.6381 39.1443C13.3079 39.697 14.1421 40 15.0143 40H33.8125C36.055 40 37.8789 38.1672 37.8789 35.9149C37.8789 35.2485 37.7182 34.6196 37.4352 34.0633C38.7916 33.4009 39.7285 32.0033 39.7285 30.3891C39.7285 29.5912 39.4987 28.8466 39.1034 28.2167C40.1613 27.4787 40.8556 26.2505 40.8556 24.8615ZM10.8022 37.1837C10.8022 37.2799 10.7243 37.3591 10.6284 37.3591H2.8029C2.70704 37.3591 2.62913 37.2799 2.62913 37.1837V17.795C2.62913 17.6987 2.70704 17.6196 2.8029 17.6196H10.6284C10.726 17.6196 10.8022 17.697 10.8022 17.795V19.3802V35.7945V37.1837ZM33.8124 37.3591H15.0142C14.7275 37.3591 14.4552 37.2491 14.2482 37.0531L13.78 36.6061C13.5583 36.3964 13.4317 36.1006 13.4317 35.7946V19.7929L18.2248 12.8331C19.162 11.4731 19.6319 9.81402 19.5472 8.16169L19.2904 3.12926C19.9204 2.82152 20.974 2.45356 22.0199 2.74758C23.1463 3.06223 24.098 4.10243 24.8487 5.83885C26.2875 9.16575 25.4889 13.5397 24.8846 15.8504C24.781 16.2459 24.8666 16.6688 25.1157 16.9921C25.3648 17.317 25.7491 17.5062 26.1565 17.5062H37.7934C38.6913 17.5062 39.4221 18.2403 39.4221 19.1412C39.4221 20.0438 38.6913 20.778 37.7934 20.778H34.0231C33.2972 20.778 32.7084 21.3694 32.7084 22.0984C32.7084 22.8275 33.2972 23.4189 34.0231 23.4189H36.7893C37.5819 23.4189 38.2264 24.0653 38.2264 24.8614C38.2264 25.6574 37.5819 26.3039 36.7893 26.3039H35.6621H34.76C34.0341 26.3039 33.4453 26.8953 33.4453 27.6243C33.4453 28.3533 34.0341 28.9447 34.76 28.9447H35.6621C36.4546 28.9447 37.0991 29.5929 37.0991 30.3889C37.0991 31.185 36.4546 31.8314 35.6621 31.8314H33.6327C32.9069 31.8314 32.3181 32.4228 32.3181 33.1518C32.3181 33.8808 32.9069 34.4723 33.6327 34.4723H33.8125C34.6051 34.4723 35.2496 35.1187 35.2496 35.9147C35.2496 36.7108 34.6049 37.3591 33.8124 37.3591Z" fill="white"/>
                </svg>';
        $msg .= '</div>';
        $msg .= '<div class="rounded-b-xl border-l border-r border-b border-gray350 p-4 sm:px-8 sm:py-10 bg-white">';
        $msg .= '<div class="">'.$rise_innovation_step_three.'</div>';
        if(!empty($rise_innovation_step_three_button_link['title'])) {
            $msg .= '<a class="open-contact-modal mt-5 bg-red innovation-contact flex items-center justify-center text-white rounded-full hover:border hover:border-red hover:text-red hover:bg-white" href="'. $rise_innovation_step_three_button_link['url'] .'">'.$rise_innovation_step_three_button_link['title'].'</a>';
        }
        $msg .= '</div></div></div>';

        return $msg;

    }

    public function rise_develop_knowledge_and_research() {

        $back_link = get_permalink(get_page_by_path('develop/knowledge-and-tools'));
        $sub_title = get_field('page_subtitle');

        $search_strings = '';
        $q = '';
        if(!empty($_GET['q'])) {
            $q = $_GET['q'];
            $search_strings = sprintf(' <a href="%s" class="text-xs text-orange">'. __('clear search', 'rise-wp-theme') .'</a>', remove_query_arg('q'));
        }



        $msg = '<div class="pt-14 flex justify-between items-start md:items-center flex-col md:flex-row">';

        $msg .= '<a href="'.$back_link.'" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center">';

        $msg .= file_get_contents(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php').'
              <span>'.__('Go back', 'rise-wp-theme').'</span></a>';
        $msg .= '<p class="text-sm text-riseDark sm:text-left mb-7">'.$sub_title.'</p>';
        $msg .= '</div>';
        $msg .= '<div class="w-full flex">';
        $msg .= '<h2 class="text-2xl dark:text-white text-black text-riseDark font-semibold">'.__('Knowledge and tools library', 'rise-wp-theme').'</h2>';
        $msg .= '</div>';
        if(!empty($search_strings)) {
            $msg .= '<div class="w-full flex mt-8">';
            $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold">'.__('Search results for "'.$q.'"', 'rise-wp-theme'). $search_strings.'</p>';
            $msg .= '</div>';
        }
        $request = home_url($_SERVER['REQUEST_URI']);
        $current_page_url_length = strlen(get_permalink());
        $is_show = strpos($request, '?', $current_page_url_length - 1) ? 'block' : 'hidden';
        $msg .= '<a href="'.get_permalink(get_the_ID()).'" name="category" value="" data-filter="" class="text-red text-base font-bold query-string-text mt-8 '. $is_show .'">'.__('Clear Filter', 'rise-wp-theme') .'</a>';
        $msg .= '<div class="flex flex-col sm:flex-row pt-8">';
        $msg .= '<div class="member-category pt-7 sm:pt-0 mb-6 sm:mb-0 sm:mr-9 flex flex-col justify-center sm:justify-start sm:flex-row sm:flex-wrap sm:block">';
        $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold mt-2">'. __('Categories','rise-wp-theme') .'</p>';
        $msg .= '<div class="flex items-center justify-between mb-7 sm:hidden">';
        $msg .= '<button class="opportunity-categories flex items-center border-gray350 px-6 py-4 text-riseBodyText border rounded-full opportunity-filter-active">';
        $msg .= __(' All categories', 'rise-wp-theme');
        $msg .= '<svg class="ml-2.5" width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>';
        $msg .= '</button>';
        $msg .= '<button class="opportunity-types flex items-center border-gray350 px-6 py-4 text-riseBodyText border rounded-full">'.__('All types', 'rise-wp-theme');
        $msg .= '<svg class="ml-2.5" width="16" height="10" viewBox="0 0 16 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>';
        $msg .= '</button>';
        $msg .= '</div>';

        $msg .= '<div class="opportunity-categories-box mt-14 mb-5 sm:mb-9 sm:mx-auto border sm:border-none rounded-lg bg-white sm:bg-transparent border-gray350 p-8 sm:p-0">';
        $msg .= $this->knowledge_hub_categories();
        $msg .= '</div></div>';
        $msg .= '<div class="w-full">';
        $msg .= $this->knowledges_types();
        $msg .= $this->knowledges_card();


        return $msg;
    }

    public function rise_develop_opportunities() {

        $panels = OpportunitiesBanner::get_instance()->get_top_banners();
        $search_strings = '';
        $q = '';
        if(!empty($_GET['q']) ) {
            $q = $_GET['q'];
            $search_strings = sprintf(' <a href="%s" class="text-xs text-orange">'. __('clear search', 'rise-wp-theme') .'</a>', remove_query_arg(['q']));
        }
        $msg = '';

        if(!empty($search_strings)) {
            $msg .= '<div class="w-full flex mt-8">';
            $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold">'.__('Search results for "'.$q.'"', 'rise-wp-theme'). $search_strings.'</p>';
            $msg .= '</div>';
        }

        $show_category = 'hidden';
        $active_category_class = '';
        if(!empty($_GET['category'])) {
            $show_category = 'block';
            $active_category_class = 'opportunity-filter-active';
        }

        $show_type = 'hidden';
        $active_type_class = '';
        if(!empty($_GET['types'])) {
            $show_type = 'block';
            $active_type_class = 'opportunity-filter-active';
        }



        $request = home_url($_SERVER['REQUEST_URI']);
        $current_page_url_length = strlen(get_permalink());
        $is_show = strpos($request, '?', $current_page_url_length - 1) ? 'block' : 'hidden';
        if(!empty($panels)){
          $msg .= ' <div id="dashboard-banners" class="relative w-full">';
          $i = 1;
          foreach ( $panels as $panel) {

            $msg .= '<div class="hiding-panel relative border border-gray360 flex flex-col sm:flex-row items-end bg-cover mt-11 md:mt-14 rounded-lg overflow-hidden"
                  style="background-image: url('.$panel['image'] .')";>';
            $msg .= '<div class="h-80 w-full sm:hidden"></div>';
            $msg .= '<div class="p-7 sm:pt-16 sm:pb-14 sm:pl-14 sm:pr-16 bg-orange200 dashboard-header-bg">';
            $msg .= ' <h2 class="mt-2 mb-0.5 text-2xl sm:text-3xl font-bold text-white">'.$panel['title'].'</h2>';
            $msg .= ' <div class="font-normal text-base text-white mt-5">'. wp_trim_words($panel['content'], 30, '...') .'</div>';
            if(!empty($panel['panel_link'])){
              $msg .= ' <a class="footer-prefix__button bg-black100 mt-8 mb-0.5" href="'.$panel['panel_link']['url'].'" >';
              $msg .= '<span>'.$panel['panel_link']['title'].'</span>';
                $msg .='<svg focusable="false"
                           width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.17 6L13.59 8.59L15 10L20 5L15 0L13.59 1.41L16.17 4H0V6H16.17Z" fill="white">
                      </svg>';
                    $msg .='</a>';
            }
            $msg .= '</div>';

            if (!empty($panel['panel_sub_image']['url'])) {
              $msg .='<div class="px-10 py-4 bg-white rounded-l-full mb-5 hidden sm:block">
                      <img src="'. $panel['panel_sub_image']['url'] .'" alt="'. $panel['panel_sub_image']['alt'].'">
                    </div>';
            }

            $msg .= '</div>';
          }

          $msg .= '</div>';
          $msg .= '<button class="hide-btn focus:outline-none ml-auto mr-5 block">'.__('Hide panel', 'rise-wp-theme').'</button>';
        }
        $msg .= '<a href="'.get_permalink(get_the_ID()).'" name="category" value="" data-filter="" class="text-red text-base font-bold query-string-text mt-8 '. $is_show .'">'.__('Clear Filter', 'rise-wp-theme') .'</a>';
        $msg .= '<div class="flex flex-col sm:flex-row mt-8 lg:mt-16">';
        $msg .= '<div class="member-category pt-7 sm:pt-0 mb-6 sm:mb-0 sm:mr-9 flex flex-col justify-center sm:justify-start sm:flex-row sm:flex-wrap sm:block">';
        $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold mb-8 lg:mb-4 mt-2">'. __('Categories','rise-wp-theme').'</p>';
        $msg .= '<div class="flex items-center justify-between mb-7 sm:hidden">';
        $msg .= '<button class="opportunity-categories flex items-center border-gray350 px-6 py-4 text-riseBodyText border rounded-full '.$active_category_class.'">';
        $msg .= __(' All categories', 'rise-wp-theme');
        $msg .= '<svg class="ml-2.5" width="16" height="10" viewBox="0 0 16 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>';
        $msg .= '</button>';
        $msg .= '<button class="opportunity-types flex items-center border-gray350 px-6 py-4 text-riseBodyText border rounded-full '. $active_type_class.'">'.__('All types', 'rise-wp-theme');
        $msg .= '<svg class="ml-2.5" width="16" height="10" viewBox="0 0 16 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                      <path d="M15 1.5L8 8.5L1 1.5" stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>';
        $msg .= '</button>';
        $msg .= '</div>';
        $msg .= '<div class="opportunity-categories-box mt-6 lg:mt-14 mb-5 sm:mb-9 sm:mx-auto border '.$show_category.' md:block sm:border-none rounded-lg bg-white sm:bg-transparent border-gray350 p-8 sm:p-0">';
        $msg .= $this->opportunities_categories();
        $msg .= '</div></div>';
        $msg .= '<div class="w-full">';
        $msg .= $this->opportunities_types();
        $msg .= $this->opportunities_card();

        return $msg;
    }

    public function opportunities_categories() {
        $opportunities_categories = Utilities::get_instance()->get_post_terms($this->opportunity_categories);
        $categories = isset($_GET['category']) ? explode(',', $_GET['category']) : [];
        $msg = '';

        if(!empty($opportunities_categories)) {

            $msg .= '<div class="member-category-checkboxes flex flex-col sm:items-start text-gray700 categories-filter">';
            foreach ($opportunities_categories as $opportunities_category) {
                $checked = in_array($opportunities_category['slug'], $categories) ? 'checked' : '';
                $msg .= '<div class="flex items-center mb-4">';
                $msg .= '<input class="cursor-pointer" type="checkbox" id="opportunities_category-'.$opportunities_category['slug'] .'" data-filter="'.$opportunities_category['slug'] .'" value="'. $opportunities_category['slug']. '" name="category" '.$checked.' />';
                $msg .= '<label for="opportunities_category-'.$opportunities_category['slug'] .'">'.$opportunities_category['title']. '</label>';
                $msg .= '</div>';
            }
            $msg .= '</div>';
        }

        return $msg;
    }


    public function knowledge_hub_categories() {
        $knowledge_categories = Utilities::get_instance()->get_post_terms($this->knowledge_categories);
        $categories = isset($_GET['category']) ? explode(',', $_GET['category']) : [];
        $msg = '';

        if(!empty($knowledge_categories)) {

            $msg .= '<div class="member-category-checkboxes flex flex-col sm:items-start text-gray700 categories-filter">';
            foreach ($knowledge_categories as $knowledge_category) {
                $checked = in_array($knowledge_category['slug'], $categories) ? 'checked' : '';
                $msg .= '<div class="flex items-center mb-4">';
                $msg .= '<input class="cursor-pointer" type="checkbox" id="opportunities_category-'.$knowledge_category['slug'] .'" data-filter="'.$knowledge_category['slug'] .'" value="'. $knowledge_category['slug']. '" name="category" '.$checked.' />';
                $msg .= '<label for="opportunities_category-'.$knowledge_category['slug'] .'">'.$knowledge_category['title']. '</label>';
                $msg .= '</div>';
            }
            $msg .= '</div>';
        }

        return $msg;
    }


    public function opportunities_types() {
        $opportunities_types = Utilities::get_instance()->get_post_terms($this->opportunity_types);

        $show_type = 'hidden';
        $types = '';
        if(!empty($_GET['types'])) {
            $show_type = 'block';
            $types = $_GET['types'];
        }

        $active = $types == '' ? 'opportunities-btn-active' : '';
        $msg = '<div class="opportunity-types-box mb-12 flex flex-col sm:block sm:text-right border border-gray350 bg-white rounded-lg sm:border-none sm:bg-transparent py-6 sm:py-0 '.$show_type.' categories-filter">
                    <button class="w-max mb-4 lg:mb-0 border border-riseBodyText px-6 rounded-full ml-4 text-sm py-2 opportunities-btn '. $active.'" name="types" value="">'. __('All', 'rise-wp-theme'). '</button>';

        if(!empty($opportunities_types)) {
            foreach($opportunities_types as $opportunities_type) {
                $active = $types == $opportunities_type['slug'] ? 'opportunities-btn-active' : '';
                $msg .= '<button class="w-max mb-4 lg:mb-0 border border-riseBodyText px-6 rounded-full ml-2 text-sm py-2 opportunities-btn '. $active .'" name="types" value="'.$opportunities_type['slug']. '">'. $opportunities_type['title'] .'</button>';
            }
        }

        $msg .= '</div>';
        return $msg;
    }


    public function knowledges_types() {
        $opportunities_types = Utilities::get_instance()->get_post_terms($this->knowledge_types, true);
        $types = isset($_GET['types']) ? $_GET['types'] : '';

        $active = $types == '' ? 'opportunities-btn-active' : '';
        $msg = '<div class="opportunity-types-box mb-12 flex flex-col sm:block sm:text-right border border-gray350 bg-white rounded-lg sm:border-none sm:bg-transparent py-6 sm:py-0 hidden categories-filter">
                    <button class="w-max mb-4 lg:mb-0 border  border-riseBodyText px-6 rounded-full ml-4 text-sm py-2 opportunities-btn '. $active.'" name="types" value="">'. __('All', 'rise-wp-theme'). '</button>';

        if(!empty($opportunities_types)) {
            foreach($opportunities_types as $opportunities_type) {
                $active = $types == $opportunities_type['slug'] ? 'opportunities-btn-active' : '';
                $msg .= '<button class="w-max mb-4 lg:mb-0 border border-riseBodyText px-6 rounded-full ml-2 text-sm py-2 opportunities-btn '. $active .'" name="types" value="'.$opportunities_type['slug']. '">'. $opportunities_type['title'] .'</button>';
            }
        }

        $msg .= '</div>';
        return $msg;
    }


    public function opportunities_card($post_per_page = '', $show_pagination = true) {
        $opportunity_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $opportunity_type = isset($_GET['types']) ? $_GET['types'] : '';

        $booked = UltimateMembers::get_instance()->get_user_bookmarks('', 'opportunities');


        $opportunity_lists = Opportunities::get_instance()->get_develop_opportunities_list($opportunity_type, $opportunity_categories, $post_per_page);

        $msg = '<div class="pb-14">';
        if(!empty($opportunity_lists['data'])) {


          $msg .= '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5" id="opportunity_cards" data-nonce="'. wp_create_nonce('um_user_bookmarks_new_bookmark'). '" >';

            foreach ($opportunity_lists['data'] as $opportunity_list) {
                $is_bookmarked = 'false';
                if(in_array($opportunity_list['id'], $booked)) $is_bookmarked = 'true';
                $remove_nonce = wp_create_nonce('um_user_bookmarks_remove_'.$opportunity_list['id']);
                $msg .= '<div class="opportunity-card-container" data-remove-nonce="'.$remove_nonce .'">';
                $msg .= '<opportunity-card image="'.$opportunity_list['image'].'"  data-id="'.$opportunity_list['id'].'" title="'. $opportunity_list['title'] .'" id="'. $opportunity_list['id'] .'" summary="'. $opportunity_list['excerpt']. '" type="'. $opportunity_list['filters']['title'] .'" link="'. $opportunity_list['link'].'" tag="'. $opportunity_list['custom_category']['title'] .'" is_bookmarked = "'.$is_bookmarked.'"></opportunity-card>';
                $msg .= '</div>';
            }
            $msg .= '</div>';

            $msg .= '<div class="flex justify-end mt-10">';
            if($show_pagination) {
                $msg .= apply_filters('member_area_pagination', $opportunity_lists['wp_query']);
            }
            $msg .= '</div>';
        } else {
            $msg .= '<div class="text-center justify-center"><p class="text-black dark:text-white">'.__('No results found.', 'rise-wp-theme').'</p></div>';
        }
        $msg .= '</div>';

        return $msg;
    }


    public function knowledges_card($post_per_page = '', $show_pagination = true) {
        $knowlegde_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $knowledge_type = isset($_GET['types']) ? $_GET['types'] : '';

        $knowledge_lists = Knowledge::get_instance()->get_all_knowledge($knowlegde_categories, $knowledge_type);

        $msg = '<div class="pb-14">';
        if(!empty($knowledge_lists['data'])) {
            $msg .= '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5" id="opportunity_cards">';

            foreach ($knowledge_lists['data'] as $knowledge) {
                $msg .= '<knowledge-card image="'. $knowledge['image'] .'" title="'. wp_trim_words($knowledge['title'],15,'...') .'"
                                category="'.$knowledge['category']['title'] .'" excerpt="'. $knowledge['excerpt'] .'"
                                link="'. $knowledge['link'] .'"
                                type="'. $knowledge['type']['title'] .'" ></knowledge-card>';
            }
            $msg .= '</div>';

            $msg .= '<div class="flex justify-end mt-10">';
            if($show_pagination) {
                $msg .= apply_filters('member_area_pagination', $knowledge_lists['wp_query']);
            }
            $msg .= '</div>';
        } else {
            $msg .= '<div class="text-center justify-center"><p class="text-black dark:text-white items-center text-center">'.__('No results found.', 'rise-wp-theme').'</p></div>';
        }
        $msg .= '</div>';

        return $msg;
    }

    public function rise_wp_tools_and_resources($atts) {
        $back_link = get_permalink(get_page_by_path('develop/knowledge-and-tools'));
        $sub_title = get_field('page_subtitle');

        $msg = '<div class="pt-14 flex justify-between items-start md:items-center flex-col md:flex-row">';
        $msg .= '<a href="'.$back_link.'" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center">';

        $msg .= file_get_contents(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php').'
              <span>'.__('Go back', 'rise-wp-theme').'</span></a>';
        $msg .= '<p class="text-sm text-riseDark sm:text-left mb-7">'.$sub_title.'</p>';
        $msg .= '</div>';
        $msg .= '<div class="w-full flex">';
        $msg .= '<h2 class="text-2xl dark:text-white text-black font-bold">'.get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library')->post_title.'</h2>';
        $msg .= '</div>';
        $msg .= '<div class="pt-8 flex justify-between items-start lg:items-center flex-col lg:flex-row">';
        $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold mt-2">'. __('Categories','rise-wp-theme') .'</p>';
        $msg .= '<div class="flex gap-4 categories-filter mt-7 lg:mt-0">';
        $msg .= $this->templates_types();
        $msg .= '</div>';
        $msg .= '</div>';
        $msg .= '<div class="flex flex-col sm:flex-row mt-7">';
        $msg .= '<div class="member-category bg-white sm:bg-transparent rounded-lg pt-7 sm:pt-0 border sm:border-none border-gray350 mb-6 sm:mb-0 sm:mr-9 flex flex-col justify-center sm:justify-start sm:flex-row sm:flex-wrap sm:block">';
        $msg .= '<div class="mb-5 sm:mb-9 mx-auto">';
        $msg .= $this->templates_categories();
        $msg .= '</div></div>';
        $msg .= $this->templates_card();
        $msg .= '</div>';

        return $msg;
    }

    public function rise_wp_tools_and_resources_webinars($atts) {
        $back_link = get_permalink(get_page_by_path('develop/knowledge-and-tools'));
        $sub_title = get_field('page_subtitle');

        $search_strings = '';
        $q = '';
        if(!empty($_GET['q'])) {
            $q = $_GET['q'];
            $search_strings = sprintf(' <a href="%s" class="text-xs text-orange">'. __('clear search', 'rise-wp-theme') .'</a>', remove_query_arg('q'));
        }


        $msg = '<div class="pt-14 flex justify-between items-start md:items-center flex-col md:flex-row">';

        $msg .= '<a href="'.$back_link.'" class="text-sm text-riseDark sm:text-left mb-7 flex gap-2 items-center">';

        $msg .= file_get_contents(RISE_THEME_SVG_COMPONENTS.'/arrow-back-colored-member-area.php').'
              <span>'.__('Go back', 'rise-wp-theme').'</span></a>';
        $msg .= '<p class="text-sm text-base text-riseDark sm:text-left mb-7">'.$sub_title.'</p>';
        $msg .= '</div>';
        $msg .= '<div class="w-full flex">';
        $msg .= '<h2 class="text-2xl dark:text-white text-black text-riseDark font-semibold">'.__('RISE Webinars', 'rise-wp-theme'). '</h2>';
        $msg .= '</div>';
        if(!empty($search_strings)) {
            $msg .= '<div class="w-full flex mt-8">';
            $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold">'.__('Search results for "'.$q.'"', 'rise-wp-theme'). $search_strings.'</p>';
            $msg .= '</div>';
        }
        $msg .= '<div class="pt-8 flex justify-between items-start lg:items-center flex-col lg:flex-row ">';
        $msg .= '<p class="text-lg text-riseDark text-center sm:text-left font-semibold mt-2">'. __('Categories','rise-wp-theme') .'</p>';
        $msg .= '</div>';
        $msg .= '<div class="flex flex-col sm:flex-row mt-7">';
        $msg .= '<div class="member-category bg-white sm:bg-transparent rounded-lg pt-7 sm:pt-0 border sm:border-none border-gray350 mb-6 sm:mb-0 sm:mr-9 flex flex-col justify-center sm:justify-start sm:flex-row sm:flex-wrap sm:block">';
        $msg .= '<div class="mb-5 sm:mb-9 mx-auto">';
        $msg .= $this->templates_categories();
        $msg .= '</div></div>';
        $msg .= '<div class="pb-14 w-full">';
        $msg .= $this->get_all_webinars();
        $msg .= '</div>';
        $msg .= '</div>';

        return $msg;
    }

    public function rise_wp_tools_and_resources_overview($atts) {
        $args = shortcode_atts([
            'limit'         => 3,
            'user_id'       => get_current_user_id(),
        ], $atts);

        $limit = $args['limit'];

        $output = '<div class="pb-10">';
        $output .= $this->get_all_tools_and_resources_summary($limit, false);
        $output .= $this->get_all_webinars_summary($limit, false);
        $output .= '</div>';


        return $output;
    }

    public function get_all_tools_and_resources_summary($paged = '', $show_pagination = true) {
        $tools_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $tools_type = isset($_GET['types']) ? $_GET['types'] : '';

        $tools_resources = Knowledge::get_instance()->get_all_knowledge($tools_type, $tools_categories, $paged);

        $tools_link = get_permalink(get_page_by_path('develop/knowledge-and-tools/knowledge-and-tools-library'));

        $search_strings = '';
        if(!empty($_GET['q'])) {
            $search_strings = sprintf(' <a href="%s" class="text-base text-orange">'. __('clear search', 'rise-wp-theme') .'</a>', remove_query_arg('q'));
        }

        $output = '';

        if(!empty($tools_resources['data'])) {
            $output .= '<div class="pt-14">';
            $output .= '<div class="flex justify-between items-center pb-10">';
            $output .= '<h2 class="text-2xl font-medium">'.__('Latest knowledge and tools', 'rise-wp-theme'). $search_strings. '</h2>';
            $output .= '<a href="'.$tools_link .'" title="'.__('View all', 'rise-wp-theme').'" class="flex items-center gap-2"><span  class="text-riseDark text-sm">'. __('View all', 'rise-wp-theme').'</span>
                      <svg
                        width="25"
                        height="24"
                        viewBox="0 0 25 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M9 5L16 12L9 19"
                          stroke="#F15400"
                          stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </a>';
            $output .= '</div>';

            $output .= $this->get_all_tools_and_resources($paged, $show_pagination);

            $output .= '</div>';
        }

        return $output;
    }

    public function get_all_webinars_summary($post_per_page = '', $show_pagination = true) {
        $tools_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $tools_type = isset($_GET['types']) ? $_GET['types'] : '';

        $tools_resources = Webinars::get_instance()->get_all_webinars($tools_type, $tools_categories, $post_per_page);

        $webinars_link = get_permalink(get_page_by_path('develop/knowledge-and-tools/webinars'));

        $output = '';

        if(!empty($tools_resources['data'])) {
            $output .= '<div class="flex justify-between items-center pb-10 pt-14">';
            $output .= '<h2 class="text-2xl font-medium">'.__('Latest RISE webinars', 'rise-wp-theme'). '</h2>';
            $output .= '<a href="'.$webinars_link .'" title="'.__('View all', 'rise-wp-theme').'" class="flex items-center gap-2"><span  class="text-riseDark text-sm">'. __('View all', 'rise-wp-theme').'</span>
                      <svg
                        width="25"
                        height="24"
                        viewBox="0 0 25 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M9 5L16 12L9 19"
                          stroke="#F15400"
                          stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </a>';
            $output .= '</div>';
            $output .= '<div class="flex justify-between items-center">';

            $output .= $this->get_all_webinars($post_per_page, $show_pagination);

            $output .= '</div>';
        }

        return $output;
    }

    public function get_all_tools_and_resources($paged = '', $show_pagination = true) {
        $tools_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $tools_type = isset($_GET['types']) ? $_GET['types'] : '';

        $tools_resources = Knowledge::get_instance()->get_all_knowledge($tools_type, $tools_categories, $paged);

        $output = '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 gap-4">';

        if(!empty($tools_resources['data'])) {
            foreach ($tools_resources['data'] as $tools_resource) {
                $title = $tools_resource['title'];
                $link = $tools_resource['link'];
                $excerpt = $tools_resource['excerpt'];
                $category = $tools_resource['category']['title'];
                $types = $tools_resource['type']['title'];

                $image = $tools_resource['image'];

                $output .= '<knowledge-card image="'. $image .'" title="'. wp_trim_words($title,15,'...') .'"
                                category="'.$category .'" excerpt="'. $excerpt .'"
                                link="'. $link .'"
                                type="'. $types .'" ></knowledge-card>';
                }
        }

        $output .= '</div>';

        if($show_pagination) $output .= apply_filters('member_area_pagination', $tools_resources['wp_query']);

        return $output;
    }

    public function get_all_webinars($post_per_page = '', $show_pagination = true) {
        $tools_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $tools_type = isset($_GET['types']) ? $_GET['types'] : '';

        $output = '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5 gap-4 w-full">';

        $tools_resources = Webinars::get_instance()->get_all_webinars($tools_type, $tools_categories, $post_per_page);

        if(!empty($tools_resources['data'])) {
            foreach ($tools_resources['data'] as $tools_resource) {
                $title = $tools_resource['title'];
                $link = $tools_resource['link'];
                $category = $tools_resource['category']['title'];

                $image = $tools_resource['image'];
                if(empty($image)) {
                    $image = $tools_resource['types']['image'];
                }


                $output .= '<webinar-card title="'. $title. '" tag="'.$category.'" link="'. $link.'" image="'. $image. '"></webinar-card>';

            }
        }
        $output .= '</div>';

        if($show_pagination) $output .= apply_filters('member_area_pagination', $tools_resources['wp_query']);

        return $output;
    }

    public function templates_types() {
        $opportunities_types = Utilities::get_instance()->get_post_terms($this->tools_resources_types, true);
        $types = isset($_GET['types']) ? $_GET['types'] : '';

        $active = 'border text-riseBodyText border-riseBodyText';
        $style = '';
        if($types == '') {
            $active = 'text-red';
            $style = 'background: rgba(241, 84, 0, 0.1)';
        }
        $msg = '<button name="types" class="py-2 px-6 cursor-pointer '.$active.' rounded-full text-sm" style="'. $style.'" value="">'. __('All', 'rise-wp-theme'). '</button>';

        if(!empty($opportunities_types)) {
            $active = 'border text-riseBodyText border-riseBodyText';
            $style = '';
            foreach($opportunities_types as $opportunities_type) {
                if($types == $opportunities_type['slug']) {
                    $active = 'text-red';
                    $style = 'background: rgba(241, 84, 0, 0.1)';
                }
                $msg .= '<button name="types" class="py-2 px-6 cursor-pointer '.$active.' rounded-full text-sm" style="'. $style.'" value="'.$opportunities_type['slug'].'">'. $opportunities_type['title'] .'</button>';
            }
        }

        $msg .= '</div>';

        return $msg;
    }


    public function webinar_categories() {
        $opportunities_categories = Utilities::get_instance()->get_post_terms($this->tools_resources_categories);
        $categories = isset($_GET['category']) ? explode(',', $_GET['category']) : [];
        $msg = '';

        if(!empty($opportunities_categories)) {
            $msg .= '<div class="member-category-checkboxes flex flex-col items-center sm:items-start text-gray700 categories-filter">';
            foreach ($opportunities_categories as $opportunities_category) {
                $checked = in_array($opportunities_category['slug'], $categories) ? 'checked' : '';
                $msg .= '<div class="flex items-center mb-4">';
                $msg .= '<input class="cursor-pointer" type="checkbox" id="templates_category-'.$opportunities_category['slug'] .'" data-filter="'.$opportunities_category['slug'] .'" value="'. $opportunities_category['slug']. '" name="category" '.$checked.' />';
                $msg .= '<label for="templates_category-'.$opportunities_category['slug'] .'">'.$opportunities_category['title']. '</label>';
                $msg .= '</div>';
            }
            $msg .= '</div>';
        }

        return $msg;
    }


    public function templates_categories() {
        $opportunities_categories = Utilities::get_instance()->get_post_terms($this->tools_resources_categories);
        $categories = isset($_GET['category']) ? explode(',', $_GET['category']) : [];
        $msg = '';

        if(!empty($opportunities_categories)) {
            $msg .= '<div class="member-category-checkboxes flex flex-col items-center sm:items-start text-gray700 categories-filter">';
            foreach ($opportunities_categories as $opportunities_category) {
                $checked = in_array($opportunities_category['slug'], $categories) ? 'checked' : '';
                $msg .= '<div class="flex items-center mb-4">';
                $msg .= '<input class="cursor-pointer" type="checkbox" id="templates_category-'.$opportunities_category['slug'] .'" data-filter="'.$opportunities_category['slug'] .'" value="'. $opportunities_category['slug']. '" name="category" '.$checked.' />';
                $msg .= '<label for="templates_category-'.$opportunities_category['slug'] .'">'.$opportunities_category['title']. '</label>';
                $msg .= '</div>';
            }
            $msg .= '</div>';
        }

        return $msg;
    }

    public function templates_card($post_per_page = '') {
        $templates_categories = !empty($_GET['category']) ? explode(',', $_GET['category']) : [];
        $templates_type = isset($_GET['types']) ? $_GET['types'] : '';

        $templates_lists = ToolResources::get_instance()->get_tools_and_resources($templates_type, $templates_categories, $post_per_page);

        $msg = '<div class="pb-14">';
        if(!empty($templates_lists['data'])) {
            $msg .= '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-5" id="opportunity_cards">';

            foreach ($templates_lists['data'] as $templates_list) {
                $msg .= '<tools-template title="'. $templates_list['title'] .'" subtitle="'. $templates_list['category']['title'] .'" link="'. $templates_list['link'].'"></tools-template>';
            }
            $msg .= '</div>';

            $msg .= '<div class="flex justify-end mt-10">';
            $msg .= apply_filters('member_area_pagination', $templates_lists['wp_query']);
            $msg .= '</div>';
        } else {
            $msg .= '<div class="text-center justify-center"><p class="text-black dark:text-white">'.__('No results found.', 'rise-wp-theme').'</p></div>';
        }
        $msg .= '</div>';

        return $msg;
    }

    public function rise_wp_update_opportunities_submission() {
        $post_id = $_POST['post_id'];
        $user_id = get_current_user_id();

        $_POST['data']['user_id'] = $user_id;
        $_POST['data']['date_submitted'] = date('Y-m-d H:i:s');
        $submission = json_encode($_POST['data']);


        try {
            add_post_meta( $post_id, 'user_opportunities_submission', $submission);
            add_post_meta( $user_id, 'user_opportunities_submitted', $post_id);

            $response['status'] = true;
            $response['status'] = __('Form submitted', 'rise-wp-theme');

            echo json_encode($response);
            wp_die();

        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            wp_die();
        }
    }


    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance() {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}
