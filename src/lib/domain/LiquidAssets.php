<?php

namespace tlcal\domain;

class LiquidAssets
{
    const UNKNOWN_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkLDhU7eY3DEAAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAC0lEQVQI12NgAAIAAAUAAeImBZsAAAAASUVORK5CYII=
START;

    const SC2_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAADC0lEQVR42n2TSUxTURSGARWB2uG1nRUBon619LVBooXTkvdJShrYMZaygokIiCw2JikPixjgsTIxTZGFITDSSuHRhCAmJJoAKCgoIAZyFnQKSasBAXBBccz31iAU18yUnuO/f838357z0R8UZfBH6RIjornmIcHmmqs1WW7rknYewBzMdixIhVnOQ6Z3tMuTc07g3m/RGNVYT6KaMMAyS5rarzB+42xl4C1OAgMVwWUjtsvVps5haUULN46MBYEAeuXnpTquMAwIhUI8ACM6Vq7UImQxt7AUbGVNgIWtCN5Nm33gq6oH2lYOQqXBjbVxGJuIjgfI0lzllJbtnkDL2HhFtWkzQWkCRXQRyrf2hSGW5LlaagM5yg0htXaI01j6pxvqcUuec4SE8ID2/rf/VKOA6HNOznc5DlrnlXuufw1NTb9xv2BoZfQxob6KN0LMUDcHHowuWby2SzobkFZEkqYMweENLZnTfa7y6//fQZnvLVNEJeS84P11s4m6rkX6E8l8YEHCBWZ2ylt7pUHnd0rXxDi8gdBkemEbbR5fHRiij+1JNiEpjo/nClP0RkGSTkDEmF8zEQF5TG6gq69/EObm50FjKiCA4WdDIysEUNd4BCRabg5rhUTzJ36LU50VaouvnNz7d1bVDnz8/NvkGXo5Poonc2Kmzl74TQNejHhAozQvinaa95MbCALymmGRjwePB0XH4MD0DTwaGnYGLVtGu37iyhD/fbbnfw/72DI9By+twPvLHKNYDaggzvUH5Fw4K7fO/XvEDDz+LqA+D014GENvYLn6azjImU22Iuq4MT5qyusrzYkUuXo17cQJVRkyPDFGbYlp9kljPOp2pgLmZ4goC/HMF+TkOEGk8sPnYoadEezQmVGzOQzA5xgO8vblGYXdbNk+sJUT17kTCKhNRIC/vhnkhuI3WCNYp/kHsEWisflU9gBYnSw8igD1JACpbGRgK6wGH6Sgx8H+ASH761JYStaMSpGmui9hGo5arJu00r85A1EYNOTY6OhyrkK0SnxuYg400xdhZdLyZgsvdXbcQvv8ZlJFQOltMAAAAASUVORK5CYII=
START;

    const BW_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACy0lEQVR42o2SXUiTURjHz3nfd5sfn27ucm/Nzzjadqznn3OacLp3bpKG5Cp0Zo8yPbOZoy0IoSyWtRZJYlJgYlYJB3oRRidd1EdlFIATdnJhgYdJEiFp4e6R2KJfSD38U553+e84kSTrZ4RFU1ThSFphHCGG1SYrUinXYfiiKkKLSXx0MhlkWlnPD6iECA53dFV+WN9wzM4NK1g2VoEoSh2m01RqNfnbcYENM0qGEapYRgcFAqRlWa4FMa83MqD1wcenjJGxyYk1b5n9aXaK3Gc3GVsj/dcWB29Gfraealw2arUvbBkZs+701MmIIr3HL5M5RBS1B3GITFmZnM6HAmZXLnee/PmxpJsN5OtJtLSKDnWEyOTpCLCZTN6zGYxhGrRbGH/UpFX02VtSAgHhQJZNKL5ZbnzJ9rXO4vdzrayadgG5kqNBBfmYOEW5p/ueylU5CTgRK0AwrMBG2dZwPP7vf3Ef/xBhI64Sf3envInrRsR4nE4N8pttqX0tLQuyGnAAlD7p+AWWXeHh1+uLy2S9qbGhXyD4ZXTWbHsP+YjobY2Uu10EeeBnsrWc7JwqjHEs5DPAFLSdoWBw5vuHeaLR5V2BplkaI+jx6nVkf4Fx2WK2LHqraz7qtFqvWCxOpWkGno+2wGGXNPH40/2Zu9hs060F3BkVdGM1VrvYadGsKieS5WJbkF8TEySmK4mPMvTeNMGLA9kTx9Fw4nQMKtTa+hWwcqQUsSw4QDaakLAzkqUpea8gQm5qHtJGAGCaHM7SLz+FuznriT5Zu3HcMNp4GVNE0fn8Uil4xMazerVHPV8soCfj3aAS1RZ9RGD/v1IcdGKWiqti9YHD4CHQJOc5lU4JQkdSXye4l9PaQRrni2WyS+eyVe+S+HwtArjd6LkiVlCIdkEHHgYLEjGdH4u3vum249hBB7ezv4gDc0EXmA/ydwa4PhZkn0G5wgUIwEf0HvwE0g7H0pir3WgAAAABJRU5ErkJggg==
START;

    const HEARTHSTONE_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC4klEQVR4AX2SQ4BsRxhGT9VtzZ0ene57HsW07WcXYxNzEtm3btm0nz+a4jenu66rYOPsfHwQAELrysuOObxL55uJgCsf2mLk88fWTHy54nGdD8DyEAQBWKicrufe5ZobgvlWfw5aeFl7qa4yvGi06+4nopwPm3ZYI/qH3jmp0XbLF6W6cKBMefn/5ke6DK1DAJP+WLR/IT96NPfrbrb870cf0L+tmj9rvZ1HId6sy5GdUOEcYU45/2yvHCwK3qzte7anZm3tlads3/VuU21d/z8WbDbQPnDSPtOfKlmBKSJRjLYOqhrroH4KuquH7J77cW9mgA/H5XpHbtb2nXDQcaf/zgsiJu8y46qF5+XZZY0JLF7StB8oAsx4vN4j/1jvoKevyWdWOLC/p1Q/bseus347Lrmaznx1POLu9nwmhDomNxiE5Bo4EMuqEZzWSYsCEc5tXxOOv01x1kSNkEIHdau3WLOYlKWI+lEZ6NKubQnlUFCIkB01oFbBfk0WHlQFcpmA4VwrGmtaY1rAciODrNzeMIHDAQCgwDsBMIIY8g45NLQ7kBrBeQQnUKSUK9LdqtsAQlnXz5rVIZjegQp8VCmF0BZ+pYwfKkBUwrJhSKfAKYI1gZ5WQyJRygPIt74Y/7ornLpWoq8GquFj5UdyJHH7gQToDg8OQTYAqYExvIVQlqAqJyrfD7lwAuXCoOMvOlL5ZuzhCoHxy4ykKnyRzRkELGIqBtoARd7QTdk1hvisnyMecVy9djABKwnv0qeeYO1ZYVDQu0AKviYYTDKFxorIfpP6VQnoe2771k/5uefm5m9AVB/rrJcvdU86rgDNrlt215HRBtbWTAsyZQDAi1BSKQUEFjkEkl/5rz5Hz78naXlPwA4BCCGMI445eMPK7HfEYj9CdZ1PVMLkkEGgArSWuBVBOVdg1czBsY+Xl48HbAABYJrR2B7rnTt1v/sLRiAY0AgVSa2WEDHy0r6XQhA00qK+/TwRzAA3wA1y7WhoWpbHzAAAAAElFTkSuQmCC
START;

    const DOTA_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABQAAAATCAYAAACQjC21AAAABmJLR0QA/wD/AP+gvaeTAAAACXBInWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkLDx0vqkz3UgAAAstJREFUOMvtlE1r3VUQh5/fzPxvnbnMTA0ZptZXE3vhSghp1U9oqvhC1xq4UsnClIHQp+DEUl4oLSRcushMrxIVQrZuu1EKs1ciNqUl8nWShpwRaT+z/j4iYx9voRnM1whjnPvJ05+uDQ2PtIo4VCQiuTr4Am6LkU9yaQpcylNF6M+wWbmfljngS1g8fTq6hvsEX041v52K8uRuiQJpOhpts+517bHLiDzj9dWV0f3AiMi3TFK5jcko1t13tEtSaI9nAXqQkmwAwyl5JmRmk5vEvNLdEWxVFW//WXcnm5WdbQ04rYbTDMMTvLBCnY+trF25XVlPO/Ts2GAfnMEwyU+XindHBeOrnTuclh9NuebURojXgtAZifKjyNycOHjzgVDc8hUuERH+Gkd9HgIU1JZtrT7afnnul03kvbnHTLBQ8Ih6qyo8PN5sWhhr8+1HAaEl7y8z6gpHX33qWoGEac+fShwydOLa2tP7+0PGPinFbO86gERjFbBrBk0K2OwGQv9JUf+5A4e0NPab2kfnZtqHwc4+V3nTDc3J1254KaeXw+Oi9k+YOU6nFg5uPWAERMWtJs2fe6D9KMCppbX1Zy8vz3iUV+VcD9Oubx/QXCPbUesw/e4GYSKCQ9Fg/vzU4Xt2nnKcXl+eU9XH3/NJduOu+/qE4X7gJN51Nr5905zcPcBPhmojKPjn/yNiRnQvPXFq5aOXaE+55w4Ohn/h56/hIOgnePXVherMkTYbnukUQID7UbVWP+s6nx8d1taI6cdNc+/6+S3TVrDhKPAyxudq50C2+FnKL3pJxE82NoXH+9A3Xlhp+83iy5PT2yARkpCt+TXSm5BamfZ3uPkn53O/KsUNhJuAzxTHL3ww79end3jIAKyAmR4moSSk9X6DkrADBw0UY/9uoOzPMIJ8uTbuUnJNyhYiVctJvViUByypUvo1MzdqdN26nZUOmOwtcKskm/8vf+6cbkEzUl0IAAAAASUVORK5CYII=
START;

    const LOL_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABEAAAASCAYAAAC9+TVUAAAABmJLR0QA/wD/AP+gvaeTAAAACXBInWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkLDxYyKr5CQAAAAqpJREFUOMvVk11Ik2EUx//bO/epn7sM559JMZ86ZufxARUwURVMvbJhZGGKQF0Ih0UVBEkVCF92VfULljUVQIEVkoyLLULtw9qX5memcnzalzc/pue/fu7WrwaqUXXfW/es55zvPj8D/nATZRbUlSfVNl4hH8i1ob0hjzg2pmqzou+1yZF5sanDKqy1Dd4PgpK8RqunzRcAIBEQFCWGVcEgMeGcNiQQ8W6+xU5cr2p3z6hkVBGKQEIJRyERojggLoznUyfNbn/8ravj1UgjgEDwIcGCMF7nCqPfIT0RL6X0Li8X04piWH0aeO0/sCfBlZyxe1vYtYejB6yLnq0vsTtgQpGrVreGEV08yoXCW34LNYIQ4TAubuBi2wT4wvhnwIxIEvQNTz/4IyU9RndJreM07NSKMnlnTA7SGRZzqIAuETTMr3wyErAvn5EXJ04qyMZKVCEUJ+GLJ4SQAgynK1jWdqtX0i2ldOBwIQ8AkEnMutAjZrh8klA8mTQej6hm8hFhPU5+H43jtWl58RoYk+H+NdI84TzPZehfPaBwYWh8Sk35DIhXB4anup4mSLJL8a76IlxLfowtSCEPFUDIB/wUg66Oj+h5Pdy95sHwuuloxERVQ4W2UyQJwDlLIskQi+8wnYN6rwp14I865TXD3XkGUXIIZu2df28uZF795skIxI7SPw0mJERSKVCpYwksxHlMNa1QGahZNIIZunguAS+GLxtrS/tdxjG7tuafwces6xTEPJ8yCaNw7Zz6sIWL/CPruIZYpGS3M6zt+29AKz+BskJDJcntLd/bLXNMbA0qVNPtwb8tNgPDiiuhJyb95y93D5doFEJDgN4w162jUB+MNBGimqN6dHM8cLtTL5OnURPMxynF0Ru+y+a6VL+Luduc5tqqjrfZ5VPz8lGaZhz4b/QLZD4AdGyMIaMAAAAASUVORK5CYII=
START;

    public static function getLabel ($type = 'unk')
    {
        switch ($type) {
            case 'sc2':
                $content = 'Star Craft II';
                break;
            case 'brw':
                $content = 'Star Craft: Broodwar';
                break;
            case 'sma':
                $content = 'Super Smash Brothers';
                break;
            case 'hrt':
                $content = 'Hearthstone';
                break;
            case 'dot':
                $content = 'Dota 2';
                break;
            case 'lol':
                $content = 'League of Legends';
                break;
            case 'unk':
            default:
                $content = 'Unknown';
        }
    }

    public static function getIconString ($type = 'unk')
    {
        switch ($type) {
            case 'sc2':
                $content = self::SC2_ICON;
                break;
            case 'brw':
                $content = self::BW_ICON;
                break;
            case 'hrt':
                $content = self::HEARTHSTONE_ICON;
                break;
            case 'dot':
                $content = self::DOTA_ICON;
                break;
            case 'lol':
                $content = self::LOL_ICON;
                break;
            case 'unk':
            default:
                $content = self::UNKNOWN_ICON;
        }
        return 'image/png;base64,' . $content;
    }

    public static function getIconNode ($type = 'unk') {
        $icon = new \DOMNode('img');
        $icon->appendChild(new \DOMAttr('src', self::getIconString($type)));
        return $icon;
    }
}
