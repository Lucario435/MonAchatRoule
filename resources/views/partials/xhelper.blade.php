@php
    if (!function_exists('dateFr')) {
        function dateFr($d)
        {
            // return \Carbon\Carbon::parse($d)->isoFormat('LL');
            $carbonDate = \Carbon\Carbon::parse($d)
                ->locale('fr_CA')
                ->setTimezone('America/Toronto');

            // Formater la date et l'heure en français canadien
        return $carbonDate->isoFormat('LLLL'); // Utilisez 'LLLL' pour le format complet en français canadien
    }

    function parseContent($content)
    {
        $tokens = explode(' ', $content);
        $parsedContent = '';

        foreach ($tokens as $token) {
            $t = strtolower($token);

            if (strpos($t, 'http://') !== false || strpos($t, 'https://') !== false) {
                // Handle URLs
                if (strpos($t, '.webp') !== false) {
                    $image = str_replace('.webp', '', $token);
                    $webp = $image . '.webp';
                    $png = $image . '.png';
                    $jpg = $image . '.jpg';
                    // $parsedContent .= '<br />';
                    $parsedContent .= "<picture class='contentImage'>";
                    $parsedContent .= "<source type='image/webp' srcset='$webp'>";
                    $parsedContent .= "<source type='image/png' srcset='$png'>";
                    $parsedContent .= "<img src='$jpg' style='width: auto;'>";
                    $parsedContent .= '</picture>';
                    $parsedContent .= '<br />';
                } else {
                    if (strpos($t, '.jpg') !== false || strpos($t, '.jpeg') !== false || strpos($t, '.png') !== false || strpos($t, '.bmp') !== false) {
                        // $parsedContent .= '<br />';
                        $parsedContent .= "<a href='$token' target='_blank'>";
                        $parsedContent .= "<img class='contentImage' src='$token' alt='' />";
                        $parsedContent .= '</a>';
                        $parsedContent .= '<br />';
                    } else {
                        if (strpos($token, 'https://www.youtube.com/watch?v=') !== false) {
                            $youtubeId = str_replace('https://www.youtube.com/watch?v=', '', $token);
                            if (strpos($youtubeId, '&') !== false) {
                                $youtubeId = substr($youtubeId, 0, strpos($youtubeId, '&'));
                            }
                            $youtubeThumbnail = 'https://i3.ytimg.com/vi/' . $youtubeId . '/maxresdefault.jpg';
                            // $parsedContent .= '<br />';
                            $parsedContent .= "<a href='$token' target='_blank'>";
                            $parsedContent .= "<img class='contentImage' src='$youtubeThumbnail' alt='' />";
                            $parsedContent .= '</a>';
                            $parsedContent .= '<br />';
                        } else {
                            $tt = explode('/', $token);
                            $sublink = $token;
                            if (count($tt) > 2) {
                                $sublink = $tt[0] . '//' . $tt[2] . '...';
                            }
                            $parsedContent .= "<a href='$token' target='_blank' class='ellipsis'>$sublink</a>";
                        }
                    }
                }
            } else {
                if (strpos($t, '[hr]') !== false) {
                    $parsedContent .= '<hr />';
                    } else {
                        $parsedContent .= "<span>$token</span>";
                    }
                }
            }
            $noSpaceContent = str_replace(' ', '', $content);
            if(strip_tags($parsedContent) == $noSpaceContent){
                return $content;
            }
            // echo  $parsedContent . " " . $noSpaceContent;
            return $parsedContent;
        }
    }
@endphp
