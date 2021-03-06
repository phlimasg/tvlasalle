<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\Post;
use App\Models\Tv;
use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.webplayer.index', [
            'filials' => Filial::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $filial = Filial::where('url', $url)->first();
        return view('public.webplayer.show', [
            'filial' => $filial,
            'tvs' => $filial->Tvs()->where('ativo', 1)->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function play($filial_url, $tv_url)
    {
        $html = file_get_contents("https://lasalle.edu.br/abel/sobre-o-colegio/noticias");
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors($internalErrors);
        $dom->preserveWhiteSpace = false;

        $tables = $dom->getElementsByTagName('section');
        //->item(0)->getElementsByTagName('div')->item(0)->attributes->item(0)->value

        $noticias = $tables->item(0)->getElementsByTagName('div');

        $news = [];


        for ($i = 0; $i < $noticias->length; $i++) {
            # code...
            if (
                isset($noticias[$i]
                    ->attributes
                    ->item(0)
                    ->value)
                && $noticias[$i]
                ->attributes
                ->item(0)
                ->value == "newsBox"
            ) {
                //var_dump($noticias[$i]);
                
                array_push(
                    $news,
                    [
                        'imagem' => $noticias[$i]->getElementsByTagName('img')->item(0)->attributes->item('0')->nodeValue,
                        //link da materia
                        'link' => 'https://lasalle.edu.br/'.$noticias[$i]->getElementsByTagName('a')->item(0)->attributes->item(1)->value,
                        'titulo' =>$noticias[$i]->getElementsByTagName('div')->item(0)
                        ->getElementsByTagName('span')->item(0)            
                        ->getElementsByTagName('h3')
                        ->item(0)
                        ->firstChild
                        ->firstChild
                        ->data,
                        'descricao' => $noticias[$i]->getElementsByTagName('div')->item(0)
                        ->getElementsByTagName('span')->item(0)
                        ->getElementsByTagName('p')->item(0)            
                        ->firstChild
                        ->firstChild
                        ->data,
                    ]
                    );
                
            }
        }       


        if (env('APP_ENV') == 'production') {
            $finance_url = "https://api.hgbrasil.com/finance?key=" . env('HG_FINANCE_KEY');
            $news_url = "https://newsapi.org/v2/top-headlines?sources=google-news-br&apiKey=" . env('NEWS_API_KEY');
            $client = new Client();

            $response = $client->get($finance_url);
            $financas = json_decode($response->getBody()->getContents());

            $response = $client->get($news_url);
            //$news = json_decode($response->getBody()->getContents());
        } else {
            $financas = json_decode('{"by":"default","valid_key":true,"results":{"currencies":{"source":"BRL","USD":{"name":"Dollar","buy":5.5459,"sell":5.5422,"variation":0.311},"EUR":{"name":"Euro","buy":6.3433,"sell":6.3412,"variation":0.198},"GBP":{"name":"Pound Sterling","buy":7.5988,"sell":null,"variation":0.29},"ARS":{"name":"Argentine Peso","buy":0.0534,"sell":null,"variation":0.204},"CAD":{"name":"Canadian Dollar","buy":4.4281,"sell":null,"variation":0.221},"AUD":{"name":"Australian Dollar","buy":4.0116,"sell":null,"variation":-0.255},"JPY":{"name":"Japanese Yen","buy":0.0488,"sell":null,"variation":0.877},"CNY":{"name":"Renminbi","buy":0.8721,"sell":null,"variation":0.321},"BTC":{"name":"Bitcoin","buy":247777.271,"sell":247777.271,"variation":-1.488}},"stocks":{"IBOVESPA":{"name":"BM\u0026F BOVESPA","location":"Sao Paulo, Brazil","points":105391.15,"variation":-0.13},"IFIX":{"name":"??ndice de Fundos de Investimentos Imobili??rios B3","location":"Sao Paulo, Brazil","points":2776.08,"variation":0.42},"NASDAQ":{"name":"NASDAQ Stock Market","location":"New York City, United States","points":14806.81,"variation":-2.51},"DOWJONES":{"name":"Dow Jones Industrial Average","location":"New York City, United States","points":36113.62,"variation":0.0},"CAC":{"name":"CAC 40","location":"Paris, French","points":7131.67,"variation":-0.96},"NIKKEI":{"name":"Nikkei 225","location":"Tokyo, Japan","points":28124.28,"variation":-1.28}},"available_sources":["BRL"],"bitcoin":{"blockchain_info":{"name":"Blockchain.info","format":["USD","en_US"],"last":42148.64,"buy":42148.64,"sell":42148.64,"variation":-1.488},"coinbase":{"name":"Coinbase","format":["USD","en_US"],"last":42205.54,"variation":-1.295},"bitstamp":{"name":"BitStamp","format":["USD","en_US"],"last":42162.92,"buy":42161.47,"sell":42141.77,"variation":-1.44},"foxbit":{"name":"FoxBit","format":["BRL","pt_BR"],"last":351098.91,"variation":-1.885},"mercadobitcoin":{"name":"Mercado Bitcoin","format":["BRL","pt_BR"],"last":236255.9188,"buy":235831.99,"sell":236255.8591,"variation":-0.983}},"taxes":[{"date":"2022-01-12","cdi":9.25,"selic":9.25,"daily_factor":1.00034749,"selic_daily":9.15,"cdi_daily":9.15}]},"execution_time":0.0,"from_cache":true}');
            //$news = json_decode('{"status":"ok","totalResults":9,"articles":[{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":"Beatriz Gomes, Leonardo Martins, Pedro Vilas Boas e Stella Borges","title":"SP vacina as primeiras crian??as contra covid; campanha na capital come??a 2??","description":"O estado de S??o Paulo aplicou hoje a primeira vacina contra a covid-19 em crian??as de 5 a 11 anos em evento organizado pelo governador Jo??o Doria (PSDB) no Hospital das Cl??nicas, na regi??o central da cidade de S??o Paulo. O in??cio oficial da campanha, no e","url":"https://noticias.uol.com.br/saude/ultimas-noticias/redacao/2022/01/14/governo-de-sao-paulo-comeca-hoje-a-vacinar-criancas-contra-covid-19.htm","urlToImage":"https://conteudo.imguol.com.br/c/noticias/cd/2022/01/14/menino-indigena-de-8-anos-foi-a-primeira-crianca-a-ser-imunizada-em-sao-paulo-1642173826873_v2_615x300.jpg","publishedAt":"2022-01-14T15:31:52+00:00","content":"O estado de S??o Paulo aplicou hoje a primeira vacina contra a covid-19 em crian??as de 5 a 11 anos em evento organizado pelo governador Jo??o Doria (PSDB) no Hospital das Cl??nicas, na regi??o central da??? [+7186 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":"Iracema Amaral","title":"Centr??o ganha mais uma batalha com a demiss??o de Fl??via Arruda do Governo","description":"Governo Bolsonaro ainda n??o se pronunciou a respeito da exonera????o de Fl??via Arruda","url":"https://www.em.com.br/app/noticia/politica/2022/01/14/interna_politica,1337467/centrao-ganha-mais-uma-batalha-com-a-demissao-de-flavia-arruda-do-governo.shtml","urlToImage":"https://i.em.com.br/s3EIKQE9XbWAbU02xihe-bZL6CE=/600x315/smart/imgsapp.em.com.br/app/noticia_127983242361/2022/01/14/1337467/ex-ministra-flavia-arruda_1_25974.jpg","publishedAt":"2022-01-14T13:48:00+00:00","content":"O??Centro ganhou mais uma no governo do presidente Jair Bolsonaro (PL) com a exonerao do cargo da ministra Flvia Arruda, da Secretaria de Governo, publicada nesta sexta-feira (14/1) no Dirio Oficial d??? [+1020 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":null,"title":"Anvisa deve aprovar at?? ter??a-feira (18) a venda de autotestes de Covid no Brasil","description":"Minist??rio da Sa??de enviou nesta quinta o pedido ?? Anvisa para autorizar testes de Covid feitos em casa. Ag??ncia j?? avan??ou com a parte t??cnica da avalia????o, o que vai agilizar a aprova????o.","url":"https://g1.globo.com/politica/noticia/2022/01/14/anvisa-deve-aprovar-ate-terca-feira-18-a-venda-de-autotestes-de-covid-no-brasil.ghtml","urlToImage":"https://s2.glbimg.com/kk_cfqheLomnCtg7I7abTQDp39U=/1200x/smart/filters:cover():strip_icc()/s01.video.glbimg.com/x720/10208824.jpg","publishedAt":"2022-01-14T13:28:47+00:00","content":"A Ag??ncia Nacional de Vigil??ncia Sanit??ria (Anvisa) trabalha para aprovar os autotestes no Brasil at?? a pr??xima ter??a-feira (18). Fontes da ag??ncia informaram ?? Globonews que os t??cnicos adiantaram o??? [+1321 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":"Cristiane Silva","title":"Cai para 118 o n??mero de trechos interditados nas rodovias de Minas","description":"No meio da semana, os pontos de interdi????o chegaram a 139, segundo o boletim. Motoristas ainda precisam redobrar a aten????o","url":"https://www.em.com.br/app/noticia/gerais/2022/01/14/interna_gerais,1337466/cai-para-118-o-numero-de-trechos-interditados-nas-rodovias-de-minas.shtml","urlToImage":"https://i.em.com.br/5D31H48--44Haae9MjvAvNgiMrk=/600x315/smart/imgsapp.em.com.br/app/noticia_127983242361/2022/01/14/1337466/20220114095524960653a.jpg","publishedAt":"2022-01-14T12:39:00+00:00","content":"Aproveite o melhor do Estado de Minas: contedos exclusivos, colunistas renomados e muitos benefcios para voc.\r\nASSINE AGORAUtilizamos tecnologia e segurana do Google para fazer a assinatura."},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":null,"title":"A resposta que Bolsonaro merece - ISTO?? Independente","description":"A carta-resposta do almirante da reserva, Ant??nio Barra Torres, reagindo em nome da Anvisa ??s afrontas do presidente Bolsonaro ??? que insinuou, levianamente, interesses escusos da entidade na defesa da vacina????o infantil -, lavou a alma de um Brasil inteiro. O???","url":"https://istoe.com.br/a-resposta-que-bolsonaro-merece/","urlToImage":"https://istoe.com.br/wp-content/uploads/sites/14/2022/01/22-1.jpg","publishedAt":"2022-01-14T12:30:00+00:00","content":"A carta-resposta do almirante da reserva, Ant??nio Barra Torres, reagindo em nome da Anvisa ??s afrontas do presidente Bolsonaro ??? que insinuou, levianamente, interesses escusos da entidade na defesa d??? [+4237 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":"Reda????o","title":"Homem mata ex-mulher a tiros e golpes de marreta, furta carro e se joga da ponte Rio-Niter??i","description":"Uma mulher foi assassinada pelo ex-marido a tiros e golpes de marreta nessa quinta-feira (13), em S??o Gon??alo, Regi??o Metropolitana do Rio de Janeiro. Sem aceitar o t??rmino da rela????o, Haroldo da Silva Amorim, de","url":"https://diariodonordeste.verdesmares.com.br/ultima-hora/pais/homem-mata-ex-mulher-a-tiros-e-golpes-de-marreta-furta-carro-e-se-joga-da-ponte-rio-niteroi-1.3180580","urlToImage":"https://diariodonordeste.verdesmares.com.br/image/contentid/policy:1.3180585:1642160428/image.jpg?h=630&q=0.6&w=1200&$p$h$q$w=f76cc5e","publishedAt":"2022-01-14T11:55:19+00:00","content":"Uma mulher foi assassinada pelo ex-marido a tiros e golpes de marreta nessa quinta-feira (13), em S??o Gon??alo, Regi??o Metropolitana do Rio de Janeiro. Sem aceitar o t??rmino da rela????o, Haroldo da Sil??? [+916 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":null,"title":"Ap??s primeiro voo cancelado, vacinas da Pfizer para crian??as chegam a Minas Gerais","description":"As 110 mil doses de Pfizer chegariam 8h15, mas, com o novo voo, chegaram ??s 9h44, segundo a Latam. Distribui????o pelo estado come??a ainda nesta sexta.","url":"https://g1.globo.com/mg/minas-gerais/noticia/2022/01/14/voo-que-chegaria-a-minas-gerais-com-doses-de-vacinas-da-pfizer-para-criancas-e-cancelado.ghtml","urlToImage":"https://s2.glbimg.com/u5abCuXnrmtWtb1CIqYXgFEHAUE=/1200x/smart/filters:cover():strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2022/K/q/jACAJ2QzCkAVMdlSD5PQ/whatsapp-image-2022-01-14-at-10.23.14.jpeg","publishedAt":"2022-01-14T10:28:03+00:00","content":"O primeiro lote de vacinas infantis da Pfizer chegou ??s 9h44 ao Aeroporto Internacional de Belo Horizonte, em Confins, nesta sexta-feira (14). As 110 mil doses da vacina chegariam ??s 8h15, mas o voo ??? [+2474 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":null,"title":"V??deo mostra momento em que rottweiler salva outros dois c??es durante enchente em Barretos, SP","description":"Cachorro Buddy foi o respons??vel por salvar a vida de malteses em temporal que atingiu a cidade na ??ltima quinta-feira (6). Chuva causou estragos pela cidade e provocou uma morte.","url":"https://g1.globo.com/sp/ribeirao-preto-franca/noticia/2022/01/14/video-mostra-momento-que-rottweiler-salva-outros-dois-caes-durante-enchente-em-barretos-sp.ghtml","urlToImage":"https://s2.glbimg.com/LNv19kuvexaU-P-sa-TTUWltCPE=/1200x/smart/filters:cover():strip_icc()/s04.video.glbimg.com/x720/10209619.jpg","publishedAt":"2022-01-14T09:00:48+00:00","content":"Em v??deos obtidos pela EPTV, afiliada da TV Globo, ?? poss??vel ver quando os c??es aparecem na varanda da casa, j?? tomada pelas ??guas (veja acima). Os animais estavam sozinhos no momento da chuva e fic??? [+2534 chars]"},{"source":{"id":"google-news-br","name":"Google News (Brasil)"},"author":"Israel Medeiros","title":"Ap??s reuni??o frustrante com Guedes, servidores da Receita mant??m mobiliza????o","description":"O sindicato que representa os auditores da Receita Federal quer intensificar as mobiliza????es nos pr??ximos dias. Funcion??rios pedem a regulamenta????o do b??nus de efici??ncia e reajuste salarial","url":"https://www.correiobraziliense.com.br/economia/2022/01/4977417-reuniao-com-guedes-foi-frustrante-dizem-servidores-da-receita.html","urlToImage":"https://midias.correiobraziliense.com.br/_midias/jpg/2022/01/13/675x450/1_49898781718_97f0da7f93_c-7326741.jpg?20220113210933?20220113210933","publishedAt":"2022-01-14T00:20:00+00:00","content":"Ap??s semanas de paralisa????o reivindicando reajuste salarial e regulamenta????o do b??nus de efici??ncia, servidores da Receita v??o intensificar a press??o em cima do Minist??rio da Economia. Na noite desta??? [+2647 chars]"}]}');
        }

        $filial = Filial::where('url', $filial_url)->first();
        $posts = $filial->Tvs()->where('url', $tv_url)->where('ativo', 1)->first()
            ->PostTv()->whereIn(
                'post_id',
                Post::select('id')->where('ativo', 1)->where('user_autorizacao', '<>', null)->where('filial_id', $filial->id)->get()
            )->get();        
        
        foreach ($posts as $i) {
            if(Storage::disk('public')->exists($i->Post->video_url) == false) 
                Storage::disk('public')->put($i->Post->video_url,Storage::disk('sftp')->get($i->Post->video_url));
        }

        return view('public.webplayer.play', [
            'filial' => $filial,
            'tv' => Tv::where('url', $tv_url)->first(),
            'posts' => $posts,
            'financas' => $financas,
            'news' => $news,
        ]);
    }

    public function tempo($filial_url, $tv_url, $latitude, $longitude)
    {
        $url = "https://api.hgbrasil.com/weather?key=" . env('HG_WEATHER_KEY') . "&lat=$latitude&lon=$longitude&user_ip=remote";
        $client = new Client();

        $response = $client->get($url);
        return json_decode($response->getBody()->getContents());
        //return json_decode('{"by":"gps","valid_key":true,"results":{"temp":28,"date":"14\/01\/2022","time":"09:45","condition_code":"29","description":"Parcialmente nublado","currently":"dia","cid":"","city":"Niter\u00f3i, RJ","img_id":"29","humidity":81,"wind_speedy":"3.6 km\/h","sunrise":"05:19 am","sunset":"06:43 pm","condition_slug":"cloud","city_name":"Niter\u00f3i","forecast":[{"date":"14\/01","weekday":"Sex","max":28,"min":23,"description":"Tempo nublado","condition":"cloudly_day"},{"date":"15\/01","weekday":"S\u00e1b","max":29,"min":23,"description":"Chuva","condition":"rain"},{"date":"16\/01","weekday":"Dom","max":29,"min":22,"description":"Chuvas esparsas","condition":"rain"},{"date":"17\/01","weekday":"Seg","max":30,"min":22,"description":"Chuvas esparsas","condition":"rain"},{"date":"18\/01","weekday":"Ter","max":30,"min":23,"description":"Chuvas esparsas","condition":"rain"},{"date":"19\/01","weekday":"Qua","max":30,"min":23,"description":"Chuvas esparsas","condition":"rain"},{"date":"20\/01","weekday":"Qui","max":29,"min":23,"description":"Chuvas esparsas","condition":"rain"},{"date":"21\/01","weekday":"Sex","max":29,"min":23,"description":"Chuvas esparsas","condition":"rain"},{"date":"22\/01","weekday":"S\u00e1b","max":29,"min":23,"description":"Chuvas esparsas","condition":"rain"},{"date":"23\/01","weekday":"Dom","max":29,"min":23,"description":"Chuva","condition":"rain"}]},"execution_time":0,"from_cache":true}');
    }
}
