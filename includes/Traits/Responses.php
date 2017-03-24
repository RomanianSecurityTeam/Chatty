<?php

namespace Chatty\Traits;

use GuzzleHttp\Client;

trait Responses
{
    public function respondWithWhores()
    {
        $firstnames = ['Lenuta', 'Ileana', 'Ciresica', 'Emilia', 'Deea', 'Simo', 'Mimi', 'Dodo', 'Lala',
            'Lili', 'Petronela', 'Cerasela', 'Elena', 'Bibi', 'Nina', 'Bale', 'Virginica', 'Izabela',
            'Virginica'];

        $lastnames = ['Silentioasa', 'Tacuta', 'Obraznica', 'Fata Rea', 'Tatoasa', 'Sexoasa', 'Laptoasa',
            'Ucigasa', 'Iubareata', 'Alcoolista', 'Bagpulista', 'Anestezista', 'Fericita', 'Tiganca Tha',
            'Curmult', 'Sahista', 'Sufletista', 'Virgina'];

        $places = ['Carrefour-ul de pe Grivitei', 'WC', 'autobuz', 'Faurei', 'cimitir', 'canal', 'depresie',
            'templu', 'patriarhie', 'masina', 'purgatoriu', 'subsol, mirosind a formol', 'beci'];

        $features = ['cur mare', 'tate', 'are clasa', 'tace', 'inghite', 'zambeste', 'face curatenie',
            'minte frumos', 'rade ca proasta', 'e cam betiva', 'face cu mana', 'te uimeste',
            'face lucruri sa dispara', 'stramta'];

        $startDays = ['Luni', 'Marti'];
        $endDays = ['Joi', 'Vineri', 'Sambata', 'Duminica'];

        $this->respond(
            sprintf(
                'Am gasit-o pe %s %s, in %s cu urmatoarele calitati: %s si %s - %s, program: %s - %s, %s',
                randarr($firstnames),
                randarr($lastnames),
                randarr($places),
                randarr($features),
                randarr($features),
                '07' . rand(2, 9) . rand(0, 9) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
                randarr($startDays),
                randarr($endDays),
                '0' . rand(8, 9) . ':00 - ' . rand(20, 23) . ':00'
            )
        );
    }

    public function respondWithUsers()
    {
        $users = $this->getUserList();
        $jobs = ['botnitar', 'bisnitar', 'traficant de lei la zoo', 'pierzator', 'liber', 'muncitor', 'somer', 'sclav',
            'stand degeaba', 'gabor', 'bagpulist', 'troll retras', 'maestru lucid in dat din cap "ca nu"',
            'descurcaret ;)', 'mort de beat in sant', 'jegos', 'puturos', 'lenes cu PFA', 'mergand in cap',
            'mancator de cacat', 'bagator de seama', 'vanzator de vibratoare', 'futator de cerbi', 'labagiu cosmonaut',
            'inginer la stat', 'om', 'labar', 'mircar', 'dentist la fabrica de tancuri', 'lucrand la un Mercedes',
            'lucrand la un Fiat', 'lucrand la un BMW', 'in parcare la Kaufland strangand carucioare pentru 50 de bani',
            'vanzand nisip pe plaja', 'citind carti pe bani', 'bisnitar de acadele', 'ascultator calificat de manele',
            'croitor', 'blanar', 'traistar', 'rogojinar', 'caldarar', 'țâgan', 'constructor de barci', 'pescar',
            'zugrav', 'cioban', 'lumanatar', 'padurar', 'asistent maternal', 'scobindu-se in nas', 'mancand de pe jos',
            'vomitator', 'prezicator', 'latrator', 'semafor', 'invatand orbii sa picteze', 'invatand ologii sa danseze',
            'invatand mutii sa rimeze', 'invatand mortii sa jongleze', 'bulangiu care nu da banii inapoi',
            'sef de raion', 'pietar', 'tarabagiu', 'ornitoring', 'jucator de curling', 'fan __USER__', 'strigator la cer',
            'expert in shemale', 'shemale', 'cioban cu facultate', 'mancand salam', 'injurandu-l pe __USER__',
            'asasin de muste', 'criminal in serie', 'fermacator', 'ornitorinc', 'vesnic neinteles', 'artist neinteles',
            'vanzand flori in piata', 'dresand cainii sa-l muste pe __USER__', 'dorindu-si sa fie ca __USER__',
            'invatand alfabetul grecesc de pe borcanul de iaurt', 'rugandu-ma sa nu-l mai chinui', 'murind de foame',
            'alergandu-l pe fallen_angel sa-i fure bicicleta de $3k', 'ajungandu-l din urma pe wHoIS la saracie',
            'rezolvand challenge-uri mai repede ca Byte-ul', 'rugandu-l pe sandabot sa-i faca SEO la site-ul de avioane',
            'scriind poezii despre shemale', 'fasolar', 'frizer', 'parizar', 'salahor', 'cersetor', 'senator',
            'pokemon', 'om matol', 'faggot', 'in dulap', 'pe chat (true AI)', 'verificand factura la curent', 'tatic',
            'felinar', 'scarba', 'mai smecher decat __USER__', 'fericit', 'beat', 'mort in viata', 'sex symbol',
            'vopsitor de camioane', 'glumeam, nu stiu cine e', 'kurd', 'kamikaze', 'terorist', 'faggot cu acte-n regula',
        ];

        if (preg_match('/\bboloboc\b/', $this->text)) {
            return $this->respond(
                sprintf(
                    'L-am gasit pe mov_0ah_01, %s - %s',
                    str_replace('__USER__', randarr($users), randarr($jobs)),
                    '07' . rand(2, 9) . rand(0, 9) . ' ' . rand(100, 999) . ' ' . rand(100, 999)
                )
            );
        }

        return $this->respond(
            sprintf(
                'L-am gasit pe %s, %s - %s',
                randarr($users),
                str_replace('__USER__', randarr($users), randarr($jobs)),
                '07' . rand(2, 9) . rand(0, 9) . ' ' . rand(100, 999) . ' ' . rand(100, 999)
            )
        );
    }

    public function respondWithJoke()
    {
        $joke_apis = [
            'http://api.yomomma.info/',
            'http://api.icndb.com/jokes/random',
        ];

        $api = randarr($joke_apis);
        $joke = false;

        // Yo momma API
        if ($api == 0) {
            $html = (new Client)->get($joke_apis[$api])->getBody()->getContents();
            $json = json_decode($html);

            $joke = $json->joke;
        }

        // ICNDB API
        elseif ($api == 1) {
            $html = (new Client)->get($joke_apis[$api])->getBody()->getContents();
            $json = json_decode($html);

            if ($json && $json->type == 'success') {
                $joke = $json->value->joke;
            }
        }

        $this->respond($joke);
    }

    public function respondWithComputation($eq)
    {
        $html = (new Client)->get('http://api.wolframalpha.com/v2/query?appid=98EL5U-AHGJLYRWH6&input=' . urlencode($eq) . '&format=plaintext')
            ->getBody()->getContents();
        $xml = simplexml_load_string($html);

        if ($xml->attributes()->success &&
            isset($xml->pod) &&
            count($xml->pod) > 0 &&
            isset($xml->pod[1]->subpod) &&
            isset($xml->pod[1]->subpod->plaintext)) {

            $this->respond($xml->pod[1]->subpod->plaintext);
        }
    }

    public function respondWithWeather($location)
    {
        $url = "http://api.wunderground.com/api/a3bbfc4d973659e7/conditions/q/" . urlencode($location) . ".json";
        $html = (new Client)->get($url)->getBody()->getContents();
        $json = json_decode($html);

        if (isset($json->current_observation))
        {
            $this->respond("{$json->current_observation->display_location->full}: [b]{$json->current_observation->temp_c}°C[/b], {$json->current_observation->weather}, {$json->current_observation->relative_humidity} humidity");
        }
    }

    public function respondWithConversion($input)
    {
        if (preg_match('#(\d+)(?: from)? (\w+)(?: to)? (\w+)#i', $input, $data)) {
            $url = "https://www.google.com/finance/converter?a={$data[1]}&from={$data[2]}&to={$data[3]}";
            $html = (new Client)->get($url)->getBody()->getContents();

            if (preg_match('#>(.*?) = <span.*?>([^<]+)#i', $html, $res)) {
                $this->respond($res[1] . ' = ' . number_format($res[2], 2) . ' ' . end(explode(" ", $res[2])));
            }
        }
    }

    public function respondWithRandomYoutubeLink()
    {
        $charmap = 'abcdefghijklmnopqrstuvwxyz-0123456789_ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $this->respond('Random YouTube Link: https://www.youtube.com/watch?v=' . substr(str_shuffle($charmap), 0, 11));
    }

    public function respondWithGiphyResult($input)
    {
        if (preg_match('/\bwhois\b/', $input)) {
            $this->respond(randarr(['http://i.giphy.com/l2JhMHaI3tA3iZcPu.gif', 'http://www.business-netz.com/sites/default/files/bilder/kein_geld_0.jpg']), false);
        }

        elseif (preg_match('/\bsandabot\b/', $input)) {
            $this->respond('https://i.imgur.com/GHpjA9o.png', false);
        }

        $json = json_decode((new Client)->get('http://api.giphy.com/v1/gifs/search?q='
            . urlencode($input) . '&api_key=dc6zaTOxFJmzC')->getBody()->getContents());

        if (count($json->data)) {
            $this->respond($json->data[rand(0, count($json->data) - 1)]->images->fixed_height->url, false);
        } else {
            $this->respond("N-am gasit nimic pe Giphy pentru: $input");
        }
    }

    public function respondWithRandomOpinion()
    {
        $oppinions = [
            'Esti un bagabont', 'Esti feroce', 'Esti praf', 'Esti degeaba', 'Esti un animal', 'Esti penal',
            'Esti in plus', 'Esti si tu pe-aici', 'Esti dar mai bine nu erai', 'Esti in stare de orice', 'Esti',
            'Erai bun, acum..', 'Esti prea sus, da-te jos de pe scaun', 'Esti la inaltime, ai invatat sa folosesti liftul',
            'Esti prea smecher, mai lasai si pe restul', 'Esti cam nevoias', 'Esti'
        ];

        return $this->respond($oppinions[array_rand($oppinions)] . '.', false);
    }

    public function respondWithIP($ip)
    {
        preg_match('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/i', $ip, $res);
        $this->respond(sprintf("root:root@%s:%d (UID: 0)", $res[1], rand(1, 65535)));
    }

    public function respondWithKick($user)
    {
        $this->kick($user);
        return $this->respond('Done!');
    }

    public function respondToVotekick($user)
    {
        $untouchableUsers = ['Gecko', 'Chatty', 'aelius', 'Nytro', 'Zatarra', 'fallen_angel', 'wHoIS', 'urs',
            'theandruala', 'badluck', 'Usr6', 'hades'];

        if (in_array($user, $untouchableUsers)) {
            return null;
        }

        if (! isset($_SESSION['votekicks'][$user])) {
            $_SESSION['votekicks'][$user] = [$this->author];
        } elseif (! in_array($this->author, $_SESSION['votekicks'][$user])) {
            $_SESSION['votekicks'][$user][] = $this->author;
        }

        $votes = count($_SESSION['votekicks'][$user]);

        if ($votes >= 3) {
            $_SESSION['votekicks'][$user] = [];
            $this->kick($user);

            return $this->respond("$user a primit kick de la prea multe voturi.");
        }

        return $this->respond("$user are $votes " . ($votes == 1 ? 'vot' : 'voturi') . " pentru a primi kick, la 3 va primi kick.");
    }
}