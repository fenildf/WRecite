function playAudio(word, type='uk') {
    var url = '/WRecite/audio/' + type + '/' + word.slice(0,2) + '/' + word + '.mp3';
    var audio = document.createElement("audio");
    old && old.pause(),
    audio.src = url,
    old = audio,
    audio.play();
}
old = null

function shuffle(array) {
    return array.sort(function() {
        return Math.random() - 0.5
    });
}


function addForgetWord(word) {
    var url = '/WRecite/forget/add?word=' + word;
    $.getJSON(url, function(ret, isSuccess){
        if  (ret.code==0) {
            alert('添加成功');
        } else if (ret.code==1) {
            alert('已添加！');
        } else {
            alert('错误！');
        }
    });
}

function removeForgetWord(word) {
    var url = '/WRecite/forget/remove?word=' + word;
    $.getJSON(url, function(ret, isSuccess){
        if  (ret.code==0) {
            alert('删除成功');
        } else {
            alert('错误！');
        }
    });
}

function buildTable(tableId, words, hidden=false) {
    var $targetTable = $('#' + tableId);
    var len = words.length;
    for (var i=0;i<len ;i++) {
        var tr = '';
        var word = words[i]['word'];
        if (hidden) {
            tr = '<tr class="hidden_word" >';
        } else {
            tr = '<tr >';
        }
        tr += '<td>' + (i+1) + '</td>';
        tr += '<td class="word_value">' + word + '</td>';
        tr += '<td class="phonetic" >'
            + '<i class="play_icon" onmouseover="playAudio(\''+ word + '\', \'uk\');"></i> 英音'
            + '&nbsp;&nbsp;&nbsp;[' + words[i]['ph_en'] + ']'
            + '<br />'
            + '<i class="play_icon" onmouseover="playAudio(\''+word + '\', \'us\');"></i> 美音'
            + '&nbsp;&nbsp;&nbsp;[' + words[i]['ph_am'] + ']'
            + '</td>';
        tr += '<td class="interpretation">' + words[i]['interpretation'] + '</td>';
        tr += '<td class="panel"><button onclick="addForgetWord(\''+word+'\');" >遗忘</button></td>';
        tr += '</tr>';
        $targetTable.append(tr);
    }
}

function DictationTable(tableId, words, info) {
    this.tableId = tableId
    this.words = words
    this.nowIndex = -1;
    this.info = $('#'+info)

    this.start = function() {
        $('#'+this.tableId).html('');
        buildTable(this.tableId, words, true);
        this.info.html('');
        this.nowIndex = -1;
    }

    this.next = function() {
        this.nowIndex++;
        this.playWord();
        $('#'+tableId + ' tr').eq(this.nowIndex).removeClass('hidden_word');
        this.info.html('当前序号' + (this.nowIndex+1) +'。')

    }

    this.playWord = function() {
        var tr = $('#'+this.tableId + ' tr').get(this.nowIndex);
        var word = $(tr).children('td').eq(1).text();
        playAudio(word, 'uk');
    }

    var self = this;
    $(document).keydown(function(event){
        if(event.keyCode==13) {
            self.next();
            event.preventDefault();
        }
        if (event.keyCode==32) {
            self.playWord();
            event.preventDefault();
        }
    });
}