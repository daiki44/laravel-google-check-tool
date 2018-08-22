<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>@yield('title')</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
</head>
<body style="padding-top: 16px;">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Google検索順位チェックツール
                </div>
                <div class="card-body">
                    <form action="#" method="GET">
                        <div class="form-group">
                            <label for="your-domain">サイトドメイン</label>
                            <input type="text" class="form-control" id="your-domain" name="your_domain" aria-describedby="domain-help" placeholder="あなたのサイトドメインを入力してください">
                            <small id="domain-help" class="form-text text-muted">※プロトコル(http/https)は入力しないでください</small>
                        </div>
                        <div class="form-group">
                            <label for="your-domain">キーワード</label>
                            <input type="text" class="form-control" id="keyword" name="keyword" aria-describedby="domain-help" placeholder="キーワードを入力してください">
                            <small id="keyword-help" class="form-text text-muted">※複数ワードの場合は半角スペース区切りで入力してください</small>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="requestSearch(); return false;">送信</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script>
function requestSearch() {
    $.blockUI();
     $.ajax({
        url: '{{ route('search') }}',
        type: 'GET',
        data: {
            'domain': $('#your-domain').val(),
            'keyword': $('#keyword').val()
        },
        dataType: 'json'
    }).done((data) => {
        let result = data.result;
        var text = '';

        if (result > 0) {
            text = result + "位です！";
        } else {
            text = "100位圏外でした";
        }
        alert(text);
    }).fail((data) => {
        console.log(data);
    }).always((data) => {
        $.unblockUI();
    });
}
</script>

@if (config('app.env') === 'production')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124458268-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-124458268-1');
</script>
@endif

</body>
</html>
