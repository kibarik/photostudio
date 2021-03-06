@extends('layouts.standart')

@section('content')

    @php

        /** @var App\Models\Order $order */
        $names = ["theBigPortraitPhoto", "mainPhotos", "commonPhotos", "designChoice"]; //массив названий фото, используется в input для определения фото
        $countsForNames = [1, $order->portraits_count, $order->photo_individual, $order->designs_count]; //применяется в JS для подсчета количества выбранных

        function getImgName($textLink) {
               //Получим имя файла из его полной ссылки
            //$imgName = preg_replace('/(?:jpg|png|gif)$/i', '', array_pop(explode('/', $link) ) );
            $imgName = explode('/', $textLink);
            $imgName = array_pop($imgName);

            //удаляем расширение файла
            //$imgName =  preg_replace('/.(?:jpg|png|gif)$/i', '', $imgName);
            return $imgName;
        }
    @endphp


<ul class="nav nav-tabs nav-justified navbar bg-light" id="myTab" role="tablist">
    <li class="nav-item">
        <a class=" nav-link active font-weight-bold" id="pills-home-tab" data-toggle="tab" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                Введите ФИО
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="pills-portraits-tab" data-toggle="tab" href="#pills-portraits" role="tab" aria-controls="pills-portraits" aria-selected="true">
            Портретные фото
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="pills-groups" aria-selected="true">
            Общие фото
        </a>
    </li>

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="design-tab" data-toggle="tab" href="#designs" role="tab" aria-controls="home" aria-selected="true">
            Дизайн
        </a>
    </li>

    @if(isset($profile))
    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="anket-tab" data-toggle="tab" href="#anket" role="tab" aria-controls="home" aria-selected="true">
            Анкета
        </a>
    </li>
    @endif

    <li class="nav-item">
        <a class=" nav-link font-weight-bold" id="final-tab" data-toggle="tab" href="#final" role="tab" aria-controls="final" aria-selected="true">
            Отправить
        </a>
    </li>

</ul>

<div class="py-3">
{{--    '$textLink' передается вместе с запросом из route   --}}
    <form class="tab-content" id="inputFormContent" method="POST" action="{{ route('orders.client.store') }}" autocomplete="off"
        onsubmit="return confirm('Вы подтверждаете, что выбрали все фотографии в нужном количество и ввели все данные? Если вы что-то пропустили, то придется повторять всю процедуру выбора с самого начала.')"
    >
        @csrf
        <input type="hidden"  name="textLink" class="d-none" value="{{  $textLink }}">

        {{-- Обязательный input - отвечает за главную фотографию --}}
        <input type="checkbox" checked="checked" class="d-none" id="{{ $names[0] }}"  name="{{$names[0]}}" value="">


        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row justify-content-center">
                <div class="form-group name-input col-12 col-lg-7 ">
                    <input type="text" onchange="tmpName=this.value" name="userName" placeholder="Имя" class="form-control" id="recipient-name">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="form-group name-input col-12 col-lg-7">
                    <input placeholder="Фамилия" onchange="tmpSurname=this.value" name="userSurname" class="form-control" id="recipient-surname">
                </div>
            </div>

            <div class="row py-3 justify-content-center">
                <div class="col-lg-7 col-12">
                    <div class="card">
                        <div class="card-header alert-danger text-center">
                            <h3>Внимание!</h3>
                        </div>

                        <div class="card-body">
                            <h5>
                                <ul class="fa-ul">
                                    <li><i class="fa fa-li fa-check-circle text-warning"></i> Вводите имя в точности, каким оно будет в альбоме</li>
                                    <li><i class="fa fa-li fa-check-circle text-warning"></i> Буквы Е/Ё И/Й имеют разницу, </li>
                                    <li><i class="fa fa-li fa-check-circle text-warning"></i> Не допускайте ошибок в имени и фамилии.</li>
                                </ul>
                            </h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-portraits" role="tabpanel" aria-labelledby="pills-portraits-tab">
            <div class="container-fluid">

                <div class="row justify-content-center ">
                    <div class="col-lg-8 col-12 h-100 py-3" style="background-color: #17a2b8; ">
                        <h5 class="text-center text-white" id="chooseHelperText">
                            Первая выбранная фотография будет использована в качестве главной для портрета. Последующие в качестве дополнений.
                            <br><br>
                            <u>Выберите {{ $countsForNames[1] }} портретных фотографий</u>
                        </h5>
                    </div>
                </div>

                <div class="row" id="portraitsPhoto">
                    @php $i=0 @endphp
                    @foreach ($portraitsPhoto as $link)
                        @php $imgName =  getImgName($link); @endphp
                        <div class="col-6 col-lg-2 nopad text-center">
                            <label class="image-checkbox">
                                <img data-name="{{$names[1]}}" src="{{ $link }}" width="100%" class="pl-2 pb-2 img-responsive" alt="">
                                <input type="checkbox" name="{{$names[1]}}[{{$imgName}}]" value="" />
                                <i class="fa fa-check d-none"></i>
                            </label>
                        </div>
                        @php $i++ @endphp
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container-fluid">

                <div class="row justify-content-center ">
                    <div class="col-lg-8 col-12 h-100 py-3" style="background-color: #17a2b8; ">
                        <h5 class="text-center text-white" id="chooseHelperText">
                            <u>Выберите {{ $countsForNames[2] }} фотографий в общий альбом</u>
                        </h5>
                    </div>
                </div>

                <div class="row" id="groupsPhoto">
                    @php $i=0 @endphp
                    @foreach ($groupsPhoto as $link)
                        @php $imgName = getImgName($link); @endphp
                        <div class="col-6 col-lg-3 nopad text-center">
                            <label class="image-checkbox ">
                                <img data-name="{{$names[2]}}" src="{{ $link }}" width="100%" class="pl-2 pb-2 img-responsive" alt="">
                                <input type="checkbox" name="{{$names[2]}}[{{$imgName}}]" value="" />
                                <i class="fa fa-check d-none"></i>
                            </label>
                        </div>
                        @php $i++ @endphp
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="designs" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container">

                <div class="row justify-content-center ">
                    <div class="col-lg-8 col-12 h-100 py-3" style="background-color: #17a2b8; ">
                        <h5 class="text-center text-white" id="chooseHelperText">
                            <u>Выберите {{ $countsForNames[3] }} варианта дизайнов для альбома</u>
                        </h5>
                    </div>
                </div>

                @if( isset($designs) )
                    @foreach($designs as $designName=>$photoUrlArray)
                    <div class="row py-2">

                        <div class="card">
                            <div class="image-checkbox">
                                <input type="checkbox" name="{{$names[3]}}[{{$designName}}]" value="" />
                                <i class="fa fa-check d-none"></i>
                                {{--                            По img используется ориентация в JS логике, только поэтому создаем этот объект--}}
                                <img style="display: none;" data-name="{{ $names[3] }}" src="" alt="">

                                <h3 class="card-header text-center"> Дизайн #{{ $designName }}</h3>
                                <div class="card-body row">
                                    @php $blockSize = 12 / count($photoUrlArray); @endphp
                                    @foreach($photoUrlArray as $photoUrl)
                                        <div class="col-lg-{{ $blockSize }} col-12">
                                            <img src="{{ $photoUrl }}" width="100%" height="100%" alt="{{ $designName }} photo" class="border border-dark rounded">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        @if(isset($profile) )
        <div class="tab-pane fade flex-center" id="anket" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row justify-content-center">
                <div class="col-md-7 col-12">
                    <div class="text-area">
                        <p class="modal-text px-3 py-2">{!! $profile !!}</p>
                    </div>

                    <div class="form-group">
                        <label for="comment">Ответ:</label>
                        <textarea name="userQuestionsAnswer" class="form-control" rows="5" id="comment"></textarea>
                    </div>
                </div>

            </div>
        </div>
        @endif


        <div class="tab-pane fade flex-center" id="final" role="tabpanel" aria-labelledby="profile-tab">

            @if ($errors->any())

                <div class="container" id="errorLog">
                    <div class="row">
                            <div class="alert alert-danger col-12">
                                <h3 class="text-center">При заполнении формы были допущены ошибки: </h3>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="Probabo-inquit-sic-a">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    </div>
                </div>
            @endif


            <div class="text-center">
                <button type="submit" class="btn Yellow-btn coolis text-white w-50 overflow-hidden" style="width: 50%;"><span>Подтвердить свой выбор</span></button>
            </div>
        </div>

    </form>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/js/mdb.min.js"></script>


<script>

    /*---Данные для AJAX запроса, изменяются во вспомогательных функциях-----*/
    /* Переменная-флаг для отслеживания того, происходит ли в данный момент ajax-запрос. */
    var inProgress = false;
    /* С какой фотографии надо делать выборку из базы при ajax-запросе. Для каждой вкладки свой счетчик*/
    var startFrom_portraits = {{ $countPhotos }};
    var startFrom_groups = {{ $countPhotos }};


    var selector = "#portraitsPhoto"; //селектор куда добавляем фото, меняется при изменении вкладки
    var isPortraitTab = 0;
    var url = "";

    /*Логика подгрузки фотографий ассинхронно через AJAX*/
    $(document).ready(function(){
        $(window).scroll(function() {

            console.log($(window).scrollTop() + $(window).height(), $(document).height() - 1000, !inProgress);
            /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 1000 && !inProgress) {

                setValuesForAjaxByActiveTab();

                $.ajax({
                    /* адрес файла-обработчика запроса */
                    url: url,
                    /* метод отправки данных */
                    method: 'GET',
                    /* данные, которые мы передаем в файл-обработчик */
                    // data: {"startFrom" : startFrom},
                    /* что php aphpphp нужно сделать до отправки запрса */
                    beforeSend: function() {
                        /* меняем значение флага на true, т.е. запрос сейчас в процессе выполнения */
                        inProgress = true;}
                    /* что нужно сделать по факту выполнения запроса */
                }).done(function(data){

                    /* Преобразуем результат, пришедший от обработчика - преобразуем json-строку обратно в массив */
                    data = jQuery.parseJSON(data);

                    /* Если массив не пуст (т.е. ссылки там есть) */
                    if (data.length > 0) {

                    /* Делаем проход по каждому результату, оказвашемуся в массиве,
                    где в index попадает индекс текущего элемента массива, а в data - ссылка на фотографию */
                        $.each(data, function(index, link){
                            /* Отбираем по идентификатору блок со статьями и дозаполняем его новыми данными */
                            var wrapper = isPortraitTab ? getImageWrapper_portraits(link) : getImageWrapper_groups(link);
                            $( selector ).append( wrapper );
                        });
                    }

                    inProgress = false; /* По факту окончания запроса снова меняем значение флага на false */

                    //меняем счетчики
                    startFrom_portraits += isPortraitTab ? ({{ $countPhotos }}*1) : 0*1;
                    startFrom_groups += isPortraitTab ? 0*1 : ({{ $countPhotos }}*1);
                });
            }
        });
    });

    function setValuesForAjaxByActiveTab() {
        //определяем переменные для AJAX запросов в разных вкладках
        var activeTab = $(".nav-link.active").attr("id");
        if(activeTab==="pills-portraits-tab"){
            selector = "#portraitsPhoto";
            isPortraitTab = true;
            url = '{{  URL::to('photo/portraits').'/'.$textLink }}/'+startFrom_portraits+'.'+ ({{$countPhotos}}*1);
        }else {
            selector = "#groupsPhoto";
            isPortraitTab = false;
            url = '{{  URL::to('photo/groups').'/'.$textLink }}/'+startFrom_groups+'.'+ ({{$countPhotos}}*1);
        }
        console.log(url);
    }

    function getImageWrapper_portraits(link){
        var imgName = getImgName(link);
        var html = '<div class="col-6 col-lg-2 nopad text-center">';
        html+= '<label class="image-checkbox">';
        html += '<img data-name="{{$names[1]}}" src="'+ link +'" width="100%" class="pl-2 pb-2 img-responsive">';
        html += '<input type="checkbox" name="{{$names[1]}}['+ imgName +']" value="" /><i class="fa fa-check d-none"></i>';
        html += '</label></div>';

        return html;
    }

    function getImageWrapper_groups(link){
        var imgName = getImgName(link);
        var html = '<div class="col-6 col-lg-3 nopad text-center">';
        html += '<label class="image-checkbox">';
        html += '<img data-name="{{$names[2]}}" src="'+ link + '" width="100%" class="pl-2 pb-2 img-responsive">';
        html += '<input type="checkbox" name="{{$names[2]}}['+ imgName +']" value="" />';
        html += '<i class="fa fa-check d-none"></i>';
        html += '</label></div>';

        return html;
    }

    function getImgName(link){
        return link.split('/').pop();
    }

</script>

<script>

    $(document).ready(function() {
        openErrorTab();
    });

    //$names - PHP массив с именами для всех инпутов см. вверх страницы
    //$countsForNames - ограничители для каждого выбора
    //создаем объект, чтобы JS передавал значения переменных по ссылкам
    var names = {
        {{$names[0]}}Count : {{$countsForNames[0]}},
        {{$names[1]}}Count : {{$countsForNames[1]}},
        {{$names[2]}}Count : {{$countsForNames[2]}},
        {{$names[3]}}Count : {{$countsForNames[3]}}
    };

    //---------------- image gallery functions----------
    // init the state from the input
    $(".image-checkbox").each(function () {
        if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
            $(this).addClass('image-checkbox-checked');
        } else {
            $(this).removeClass('image-checkbox-checked');
        }
    });

    // sync the state to the input. Используется для динамического DOM, поэтому селектор идет от "body"
    $("body").on("click", '.image-checkbox', function (e) {

        var dataNameString= $(this).find('img').attr('data-name');
        var $checkbox = $(this).find('input[type="checkbox"]');

        //выбор доступен только, если мы не вышли за допустимый максимум выбора (получает от сервера)
        fullName = dataNameString + 'Count';
        if(names[fullName] > 0){
            $(this).toggleClass('image-checkbox-checked');
            $checkbox.prop("checked", !$checkbox.prop("checked"));

            //если пользователь выбираем главную фотографии
            if( !isMainPhotoSelected && dataNameString==='{{ $names[1]  }}') {
                userChangeMainPhotoChoice($checkbox, );
            }

            //Если изображение выбрано -> отнимаем от максимума, иначе прибаляет к максимуму
            $checkbox.prop("checked") ? countImgInput('-', dataNameString, this): countImgInput('+', dataNameString, this);
        }
        else {    //В других случаях мы можем только отменить свой выбор
            if( $checkbox.prop("checked") ){
                $checkbox.prop("checked", false);
                $(this).toggleClass('image-checkbox-checked');

                //для главного фото нужно обнулить флаг
                if( isMainPhoto(this)) {
                    isMainPhotoSelected = false;
                }

                deleteDecorationClasses(this);
                names[fullName]+=1;
            }
            else {
                msgEnoughSelected();
            }
        }
        e.preventDefault();
    });

    function userChangeMainPhotoChoice($checkbox){
        $name = $checkbox.attr('name');

        //очищаем имя от лишних элементов, оставим только имя фотографии
        $name = $name.replace('{{ $names[1] }}', '');
        $name = $name.replace('[', '');
        $name = $name.replace(']', '');

        $biggestPortraitUserChoice = $('input[id="{{ $names[0] }}"]').val($name);
        console.log($biggestPortraitUserChoice.val());
    }


    function msgEnoughSelected() {
        alert('Нельзя выбирать фотографий больше положенного. Сначала уберите какую-то другую фотографию.');
    }
    //--------------------------END (image Gallery) ---------------------------------


    //-------------- Счетчики количество выбранных фото ----------------

    //Ищет от какой именно секции пришел запрос
    //Изображения отличаются в атрибуте "data-name",
    //по нему отличаем секции выбора
    function countImgInput( mathAction, nameString, object) {
        switch (nameString)
        {
            //!! $names[0] применялся для тестов, не удаляется из-за смещения адрессации по всему коду
            //mainPhotos исходя из $names[1]
            case '{{$names[1]}}':
                count  = names.{{$names[1]}}Count += mathAction==="+" ? 1 : -1;
                decorateMainPhotoChoice(object, count, mathAction);
                isLastChoice(count) ? showSuccessModal() : 0;
                break;

            //commonPhotos исходя из $names[2]
            case '{{$names[2]}}':
                count = names.{{$names[2]}}Count += mathAction==="+" ? 1 : -1;
                isUnselectedAction(mathAction) ? deleteDecorationClasses(object) : decorateSelectedPhoto(object);
                isLastChoice(count) ? showSuccessModal() : 0;
                break;

            //designChoice исходя из $names[3]
            case '{{$names[3]}}':
                count = names.{{$names[3]}}Count += mathAction === "+" ? 1 : -1;
                isUnselectedAction(mathAction) ? deleteDecorationClasses(object) : decorateSelectedPhoto(object);
                isLastChoice(count) ? showSuccessModal() : 0;
                break;
        }
    }

    //отобразить модальное окно об окончании выбора
    function showSuccessModal(){
        alert('Выбрано достаточное количество фотографий, можете переходить к следующему разделу.');
    }

    //Логика идет на вычитание, если выбор сделан от max - 1 иначе к текущему +1
    //если пользователь отменяет выбор знак + иначе -
    function isUnselectedAction(mathAction){
        return mathAction === "+";
    }

    //Внимание! При выборе картинки мы от максимума отнимаем один, при отмене выбора добавляем
    //Поэтому вывод достигается при countVar==0
    function isLastChoice(countVar){
        return countVar === 0;
    }

    //Визуально отделять главное и доп. портретное фото
    var isMainPhotoSelected = false; //выбрана ли главная фотогарфия
    function decorateMainPhotoChoice(object, count, mathAction){

        //выбрана первая фотография - она выделяется в качестве главной
        if (count === {{ $countsForNames[1]}} ) {
            decorateMainPhoto(object);
            isMainPhotoSelected = true;
        } else if (!isMainPhotoSelected) { //если пользователь отменял свой выбор
            decorateMainPhoto(object);
            isMainPhotoSelected = true;
        }
        else { //выбрана не главная фотография
            decorateSelectedPhoto(object);
        }

        console.log(count, {{ $countsForNames[1]-1 }}, isMainPhotoSelected);

        //если отменили действие - снимаем все декорации

        if(mathAction==="+") {
            isMainPhoto(object) ? isMainPhotoSelected=false : isMainPhotoSelected=true;
            deleteDecorationClasses(object);
        }
    }

    function decorateMainPhoto(object) {
        $(object).addClass('gradient-main');
    }

    function decorateSelectedPhoto(object) {
        $(object).addClass('gradient-alt');
    }

    function deleteDecorationClasses(object){
        $(object).removeClass('gradient-main gradient-alt');
    }

    function isMainPhoto(object) {
        return !!($(object).hasClass('gradient-main'));
    }

    //------------------------END (счетчики выбора)-----------------
    //---------------------- (Валидация на заполнение) -------------
    /*
    function frontend_validation() {
        (document.getElementsByName('userName').value) ? true : showError('Заполните поле ИМЯ');
        (document.getElementsByName('userSurname').value) ? true : showError('Заполните поле ФАМИЛИЯ');

        check_inputsForSection(document.getElementByName( {{ $names[1] }} ), " Портретные фото ");
        check_inputsForSection(document.getElementByName( {{ $names[2] }} ), " Общие фото");

        // check_designs();
        // check_anket();
    }

    function check_name() {
        let userName  = document.getElementsByName('userName');
    }

    function isChoicesEnought(arrNow, max){
        return arrNow.length === max;
    }

    function check_inputsForSection(inputsArr, strNameOfSection){
        let validation = isChoicesEnought(inputsArr);
        if( !validation) {
            showError('Количество выбранных фотографий для раздела "'+ strNameOfSection +'" фото не соответствует '+ {{ $countsForNames[1] }});
        }
    }

    function isValue(){
        return !object.value;
    }

    function showError(msg){
        alert(msg);
    }
    */
    //-----------Error log functions----------------------
    function openErrorTab() {
        if( $('#errorLog').length ) {
            $('.nav-tabs a[href="#final"]').tab('show');
        }
    }
</script>
@endsection
