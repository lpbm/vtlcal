<?php

namespace tlcal\domain;

class LiquidAssets
{
    const UNKNOWN_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkLDhU7eY3DEAAAAB1pVFh0Q29tbWVudAAAAAAAQ3JlYXRlZCB3aXRoIEdJTVBkLmUHAAAAC0lEQVQI12NgAAIAAAUAAeImBZsAAAAASUVORK5CYII=
START;

    const SC2_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAADC0lEQVR42n2TSUxTURSGARWB2uG1\nRUBon619LVBooXTkvdJShrYMZaygokIiCw2JikPixjgsTIxTZGFITDSSuHRhCAmJJoAKCgoIAZyF\nQKSasBAXBBccz31iAU18yUnuO/f838357z0R8UZfBH6RIjornmIcHmmqs1WW7rknYewBzMdixIhV\nOQ6Z3tMuTc07g3m/RGNVYT6KaMMAyS5rarzB+42xl4C1OAgMVwWUjtsvVps5haUULN46MBYEAeuX\npTquMAwIhUI8ACM6Vq7UImQxt7AUbGVNgIWtCN5Nm33gq6oH2lYOQqXBjbVxGJuIjgfI0lzllJbt\nkDL2HhFtWkzQWkCRXQRyrf2hSGW5LlaagM5yg0htXaI01j6pxvqcUuec4SE8ID2/rf/VKOA6HNOz\nc5DlrnlXuufw1NTb9xv2BoZfQxob6KN0LMUDcHHowuWby2SzobkFZEkqYMweENLZnTfa7y6//fQZ\nvLVNEJeS84P11s4m6rkX6E8l8YEHCBWZ2ylt7pUHnd0rXxDi8gdBkemEbbR5fHRiij+1JNiEpjo/\nClP0RkGSTkDEmF8zEQF5TG6gq69/EObm50FjKiCA4WdDIysEUNd4BCRabg5rhUTzJ36LU50Vaouv\nNz7d1bVDnz8/NvkGXo5Poonc2Kmzl74TQNejHhAozQvinaa95MbCALymmGRjwePB0XH4MD0DTwaG\nYGLVtGu37iyhD/fbbnfw/72DI9By+twPvLHKNYDaggzvUH5Fw4K7fO/XvEDDz+LqA+D014GENvYL\n6azjImU22Iuq4MT5qyusrzYkUuXo17cQJVRkyPDFGbYlp9kljPOp2pgLmZ4goC/HMF+TkOEGk8sP\nYoadEezQmVGzOQzA5xgO8vblGYXdbNk+sJUT17kTCKhNRIC/vhnkhuI3WCNYp/kHsEWisflU9gBY\nSw8igD1JACpbGRgK6wGH6Sgx8H+ASH761JYStaMSpGmui9hGo5arJu00r85A1EYNOTY6OhyrkK0S\nxuYg400xdhZdLyZgsvdXbcQvv8ZlJFQOltMAAAAASUVORK5CYII=
START;

    const BW_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACy0lEQVR42o2SXUiTURjHz3nfd5sf\n27ucm/Nzzjadqznn3OacLp3bpKG5Cp0Zo8yPbOZoy0IoSyWtRZJYlJgYlYJB3oRRidd1EdlFIATd\nJhgYdJEiFp4e6R2KJfSD38U553+e84kSTrZ4RFU1ThSFphHCGG1SYrUinXYfiiKkKLSXx0MhlkWl\nPD6iECA53dFV+WN9wzM4NK1g2VoEoSh2m01RqNfnbcYENM0qGEapYRgcFAqRlWa4FMa83MqD1wce\njJGxyYk1b5n9aXaK3Gc3GVsj/dcWB29Gfraealw2arUvbBkZs+701MmIIr3HL5M5RBS1B3GITFmZ\nM6HAmZXLnee/PmxpJsN5OtJtLSKDnWEyOTpCLCZTN6zGYxhGrRbGH/UpFX02VtSAgHhQJZNKL5Zb\nzJ9rXO4vdzrayadgG5kqNBBfmYOEW5p/ueylU5CTgRK0AwrMBG2dZwPP7vf3Ef/xBhI64Sf3envI\nrRsR4nE4N8pttqX0tLQuyGnAAlD7p+AWWXeHh1+uLy2S9qbGhXyD4ZXTWbHsP+YjobY2Uu10EeeB\nsrWc7JwqjHEs5DPAFLSdoWBw5vuHeaLR5V2BplkaI+jx6nVkf4Fx2WK2LHqraz7qtFqvWCxOpWkG\no+2wGGXNPH40/2Zu9hs060F3BkVdGM1VrvYadGsKieS5WJbkF8TEySmK4mPMvTeNMGLA9kTx9Fw4\nQMKtTa+hWwcqQUsSw4QDaakLAzkqUpea8gQm5qHtJGAGCaHM7SLz+FuznriT5Zu3HcMNp4GVNE0f\n8Uil4xMazerVHPV8soCfj3aAS1RZ9RGD/v1IcdGKWiqti9YHD4CHQJOc5lU4JQkdSXye4l9PaQRr\ni2WyS+eyVe+S+HwtArjd6LkiVlCIdkEHHgYLEjGdH4u3vum249hBB7ezv4gDc0EXmA/ydwa4PhZk\n0G5wgUIwEf0HvwE0g7H0pir3WgAAAABJRU5ErkJggg==
START;

    const HEARTHSTONE_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABEAAAASCAYAAAC9+TVUAAAABmJLR0QA/wD/AP+gvaeTAAAACXBI\nWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkLDxYyKr5CQAAAAqpJREFUOMvVk11Ik2EUx//bO/ep\n7sM559JMZ86ZufxARUwURVMvbJhZGGKQF0Ih0UVBEkVCF92VfULljUVQIEVkoyLLULtw9qX5memc\nzalzc/pue/fu7WrwaqUXXfW/es55zvPj8D/nATZRbUlSfVNl4hH8i1ob0hjzg2pmqzou+1yZF5sa\nDKqy1Dd4PgpK8RqunzRcAIBEQFCWGVcEgMeGcNiQQ8W6+xU5cr2p3z6hkVBGKQEIJRyERojggLoz\nUyfNbn/8ravj1UgjgEDwIcGCMF7nCqPfIT0RL6X0Li8X04piWH0aeO0/sCfBlZyxe1vYtYejB6yL\nq0vsTtgQpGrVreGEV08yoXCW34LNYIQ4TAubuBi2wT4wvhnwIxIEvQNTz/4IyU9RndJreM07NSKM\nlnTA7SGRZzqIAuETTMr3wyErAvn5EXJ04qyMZKVCEUJ+GLJ4SQAgynK1jWdqtX0i2ldOBwIQ8AkE\nMutAjZrh8klA8mTQej6hm8hFhPU5+H43jtWl58RoYk+H+NdI84TzPZehfPaBwYWh8Sk35DIhXB4a\nup4mSLJL8a76IlxLfowtSCEPFUDIB/wUg66Oj+h5Pdy95sHwuuloxERVQ4W2UyQJwDlLIskQi+8w\nYN6rwp14I865TXD3XkGUXIIZu2df28uZF795skIxI7SPw0mJERSKVCpYwksxHlMNa1QGahZNIIZu\nguAS+GLxtrS/tdxjG7tuafwces6xTEPJ8yCaNw7Zz6sIWL/CPruIZYpGS3M6zt+29AKz+BskJDJc\ntLd/bLXNMbA0qVNPtwb8tNgPDiiuhJyb95y93D5doFEJDgN4w162jUB+MNBGimqN6dHM8cLtTL5O\nURPMxynF0Ru+y+a6VL+Luduc5tqqjrfZ5VPz8lGaZhz4b/QLZD4AdGyMIaMAAAAASUVORK5CYII=
START;

    const DOTA_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABQAAAATCAYAAACQjC21AAAABmJLR0QA/wD/AP+gvaeTAAAACXBI\nWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3wkLDx0vqkz3UgAAAstJREFUOMvtlE1r3VUQh5/fzPxv\nbnMTA0ZptZXE3vhSghp1U9oqvhC1xq4UsnClIHQp+DEUl4oLSRcushMrxIVQrZuu1EKs1ciNqUl8\nWShpwRaT+z/j4iYx9voRnM1whjnPvJ05+uDQ2PtIo4VCQiuTr4Am6LkU9yaQpcylNF6M+wWbmflj\ngS1g8fTq6hvsEX041v52K8uRuiQJpOhpts+517bHLiDzj9dWV0f3AiMi3TFK5jcko1t13tEtSaI9\nAXqQkmwAwyl5JmRmk5vEvNLdEWxVFW//WXcnm5WdbQ04rYbTDMMTvLBCnY+trF25XVlPO/Ts2GAf\nMEwyU+XindHBeOrnTuclh9NuebURojXgtAZifKjyNycOHjzgVDc8hUuERH+Gkd9HgIU1JZtrT7af\nnul03kvbnHTLBQ8Ih6qyo8PN5sWhhr8+1HAaEl7y8z6gpHX33qWoGEac+fShwydOLa2tP7+0PGPi\nFbO86gERjFbBrBk0K2OwGQv9JUf+5A4e0NPab2kfnZtqHwc4+V3nTDc3J1254KaeXw+Oi9k+YOU6\nFg5uPWAERMWtJs2fe6D9KMCppbX1Zy8vz3iUV+VcD9Oubx/QXCPbUesw/e4GYSKCQ9Fg/vzU4Xt2\nnKcXl+eU9XH3/NJduOu+/qE4X7gJN51Nr5905zcPcBPhmojKPjn/yNiRnQvPXFq5aOXaE+55w4Oh\n/h56/hIOgnePXVherMkTYbnukUQID7UbVWP+s6nx8d1taI6cdNc+/6+S3TVrDhKPAyxudq50C2+F\nKL3pJxE82NoXH+9A3Xlhp+83iy5PT2yARkpCt+TXSm5BamfZ3uPkn53O/KsUNhJuAzxTHL3ww79e\nd3jIAKyAmR4moSSk9X6DkrADBw0UY/9uoOzPMIJ8uTbuUnJNyhYiVctJvViUByypUvo1MzdqdN26\nZUOmOwtcKskm/8vf+6cbkEzUl0IAAAAASUVORK5CYII=
START;

    const LOL_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC4klEQVR4AX2SQ4BsRxhGT9VtzZ0e\ne57HsW07WcXYxNzEtm3btm0nz+a4jenu66rYOPsfHwQAELrysuOObxL55uJgCsf2mLk88fWTHy54\nGdD8DyEAQBWKicrufe5ZobgvlWfw5aeFl7qa4yvGi06+4nopwPm3ZYI/qH3jmp0XbLF6W6cKBMef\n/5ke6DK1DAJP+WLR/IT96NPfrbrb870cf0L+tmj9rvZ1HId6sy5GdUOEcYU45/2yvHCwK3qzte7a\nZm3tlads3/VuU21d/z8WbDbQPnDSPtOfKlmBKSJRjLYOqhrroH4KuquH7J77cW9mgA/H5XpHbtb2\nXDQcaf/zgsiJu8y46qF5+XZZY0JLF7StB8oAsx4vN4j/1jvoKevyWdWOLC/p1Q/bseus347Lrmaz\nx1POLu9nwmhDomNxiE5Bo4EMuqEZzWSYsCEc5tXxOOv01x1kSNkEIHdau3WLOYlKWI+lEZ6NKubQ\nlUFCIkB01oFbBfk0WHlQFcpmA4VwrGmtaY1rAciODrNzeMIHDAQCgwDsBMIIY8g45NLQ7kBrBeQQ\nUKSUK9LdqtsAQlnXz5rVIZjegQp8VCmF0BZ+pYwfKkBUwrJhSKfAKYI1gZ5WQyJRygPIt74Y/7or\nLpWoq8GquFj5UdyJHH7gQToDg8OQTYAqYExvIVQlqAqJyrfD7lwAuXCoOMvOlL5ZuzhCoHxy4ykK\nyRzRkELGIqBtoARd7QTdk1hvisnyMecVy9djABKwnv0qeeYO1ZYVDQu0AKviYYTDKFxorIfpP6VQ\noe2771k/5uefm5m9AVB/rrJcvdU86rgDNrlt215HRBtbWTAsyZQDAi1BSKQUEFjkEkl/5rz5Hz78\naXlPwA4BCCGMI445eMPK7HfEYj9CdZ1PVMLkkEGgArSWuBVBOVdg1czBsY+Xl48HbAABYJrR2B7r\nTt1v/sLRiAY0AgVSa2WEDHy0r6XQhA00qK+/TwRzAA3wA1y7WhoWpbHzAAAAAElFTkSuQmCC
START;
    const CSGO_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJ\nbWFnZVJlYWR5ccllPAAAATxJREFUeNpi+P//PwMIYwE8QHwPiC8CMSuyBIp6mAHI+P779yCpKJA0\nEH8BYmmocjYgVu7v75fFMAAGGhoKQFQHVDMIPwHi80B8CYhPAfFOIM4HYh0gVmLA4YVLSAaA8Gsg\nfgvErUgu4QRiDrgBDgIKMIPs0TS/A+J/ULY2RkhhccEMNAOuAHE8KEzOr9/PQIwB1WgGfAJiXgYc\ngAmL2Cc0fg8Qf4Zx7q8/T9AF3WguWAWSnz9/PlxBQEICXgP6oRpXgiyEsqPXr1+PYnFDQQNDgEMA\nVgN2gzQJKCiA2K5QA07hCgO4Af0QJ7JDNcwFOwUithgqxobXACiogCpWQlKyAYj/EBMLckAcCcR3\ngQbeQxK/C8UEDXCBxncZIyMjspoXQKwGxAqEDDACYgEgvoaWbc9As3UhNgMAAgwA87G2Kr3+QKAA\nAAAASUVORK5CYII=
START;
    const SMASH_ICON =<<<START
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAAr0lEQVR4AYXRs0IEcACA8V9cs223\n9hiHualHCGvmnhtr65myMWfzfPd9fxui0WLKpEFVUhD0/u2zbRWiGFABQt7/PdMHUOdWMwh7j/JU\nGbDrXcv/gGi3oN7r/4Cgd9E+Kmbou9gcNSDaMNPfhaYUA0ZkHpAtX74s/JajzJVNjhkLikG3RUu/\nLlowIQt2Ut5iBahykXTAviKAfuUJD3WgXTTRf+HeqiJJaDBmVFAhAB/6CHB/GRUzdAAAAABJRU5E\nrkJggg==
START;

    const ALL_ID = 'all';
    const UNK_ID =  'unk';
    const PFW_ID =  'pfw';
    const TL_ID =  'tl';

    // tl
    const SC2_ID = 'sc2';
    const BRW_ID =  'brw';
    const SMA_ID =  'sma';
    const HRT_ID =  'hrt';
    const DOT_ID =  'dot';
    const LOL_ID =  'lol';
    const CSG_ID =  'csg';

    // +>>
    const QLV_ID =  'qlv';
    const QIV_ID =  'qiv';
    const QIII_ID ='qiii';
    const QII_ID =  'qii';
    const QW_ID =   'qw';
    const DBT_ID =  'dbt';
    const DOOM_ID = 'doom';
    const RFL_ID =  'rfl';
    const OVW_ID =  'ovw';
    const GG_ID =   'gg';
    const UT_ID =   'ut';
    const WSW_ID =  'wsw';
    const DBMB_ID = 'dbmb';
    const XNT_ID =  'xnt';
    const QCH_ID =  'qch';
    const CPMA_ID = 'cpma';

    private static $fullLabels = [
        self::SC2_ID => 'Star Craft II',
        self::BRW_ID => 'Star Craft: Broodwar',
        self::SMA_ID => 'Super Smash Brothers',
        self::HRT_ID => 'Hearthstone',
        self::DOT_ID => 'Dota 2',
        self::LOL_ID => 'League of Legends',
        self::CSG_ID => 'Counter Strike: Global Offensive',

        self::QLV_ID => 'Quake Live',
        self::QIV_ID => 'Quake 4',
        self::QIII_ID => 'Quake III',
        self::QII_ID => 'Quake II',
        self::QW_ID => 'Quake Wars',
        self::DBT_ID => 'Diabotical',
        self::DOOM_ID => 'DOOM',
        self::RFL_ID => '',
        self::OVW_ID => 'Overwatch',
        self::GG_ID => '',
        self::UT_ID => 'Unreal Tournament',
        self::WSW_ID => 'Warsow',
        self::DBMB_ID => '',
        self::XNT_ID => 'Xonotical',
        self::QCH_ID => 'Quake: Champions',
        self::CPMA_ID => '',

        self::ALL_ID => 'All',
        self::PFW_ID => 'Plus Forward',
        self::TL_ID => 'Team Liquid',
        self::UNK_ID => 'Unknown',
    ];

    private static $invalidTypes = [
        self::ALL_ID,
        self::PFW_ID,
        self::TL_ID,
        self::UNK_ID,
        ];
    private static $labels = [
        self::SC2_ID => 'SC2',
        self::BRW_ID => 'SCBW',
        self::SMA_ID => 'SmashBros',
        self::HRT_ID => 'Hearthstone',
        self::DOT_ID => 'Dota2',
        self::LOL_ID => 'LoL',
        self::CSG_ID => 'CSGO',
        self::ALL_ID => 'TL',

        self::QLV_ID => 'QLive',
        self::QIV_ID => 'Q4',
        self::QIII_ID => 'QIII',
        self::QII_ID => 'QII',
        self::QW_ID => 'QWars',
        self::DBT_ID => 'Dbtical',
        self::DOOM_ID => 'DOOM',
        self::RFL_ID => '',
        self::OVW_ID => 'Owatch',
        self::GG_ID => '',
        self::UT_ID => 'UT',
        self::WSW_ID => 'Wsow',
        self::DBMB_ID => '',
        self::XNT_ID => 'Xono',
        self::QCH_ID => 'QChamp',
        self::CPMA_ID => '',

        self::ALL_ID => 'All',
        self::PFW_ID => '+⏩',
        self::TL_ID => 'Liquid',
        self::UNK_ID => 'Unk',
    ];

    /**
     * @param string $type
     * @return bool
     */
    public static function validType($type)
    {
        return !in_array($type, self::$invalidTypes) && array_key_exists($type, self::$labels);
    }

    /**
     * @param string $type
     * @return string
     */
    public static function getLabel ($type = self::UNK_ID)
    {
        if (!array_key_exists($type, self::$labels)) {
            $type = self::UNK_ID;
        }
        return self::$labels[$type];
    }

    /**
     * @param string $type
     * @return string
     */
    public static function getFullLabel ($type = self::UNK_ID)
    {
        if (!array_key_exists($type, self::$fullLabels)) {
            $type = self::UNK_ID;
        }
        return self::$fullLabels[$type];
    }

    public static function getIconString ($type = self::UNK_ID)
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
        return 'data:image/png;base64,' . $content;
    }

    public static function getIconNode ($type = self::UNK_ID) {
        $icon = new \DOMNode('img');
        $icon->appendChild(new \DOMAttr('src', self::getIconString($type)));
        return $icon;
    }
}
