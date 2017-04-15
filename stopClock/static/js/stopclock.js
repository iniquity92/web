var Clock = function(){
  this._amm=0; //active clock minutes
  this._ass=0; //active clock seconds
  this._rmm=0; //rest clock minutes
  this._rss=0; //rest clock seconds
  this._timer=0; 
  this._tmm=-999;//timer clock minutes
  this._tss=-999;//timer clock seconds
  this._startTime=0;
  this._endTime=0;
  this._runTime=0;
  this._pauseDuration=0;
  this._pauseBegin=0;
  this._pauseEnd=0;
  this._clockPaused=0;
  this._currentClock=0;
  this._cmm=0;//current clock minutes
  this._css=0;//current clock seconds
  this._displayMin="";
  this._displaySec="";
  this._longAudioPlayed = 0;
}
Clock.prototype.resetDisplay = function(_display){
  var _mm;
  var _ss;
  var _dMin;
  var _dSec;
  switch(_display){
    case "rest":
      _mm = this._rmm;
      _ss = this._rss;
      _dMin = "#restMin";
      _dSec = "#restSec";
      break;
    case "work":
      _mm = this._amm;
      _ss = this._ass;
      _dMin = "#workMin";
      _dSec = "#workSec";
      break;
  }
  _mm = (_mm<10)?"0"+_mm:_mm;
  _ss = (_ss<10)?"0"+_ss:_ss;
  $(_dMin).html(_mm);
  $(_dSec).html(_ss);
}
Clock.prototype.changeCurrentClock = function(){
  switch(this._currentClock){
    case 0:
      this._cmm = this._amm;
      this._css = this._ass;
      this._displayMin = "#workMin";
      this._displaySec = "#workSec";
      this.resetDisplay("rest");
      break;
    case 1:
      this._cmm = this._rmm;
      this._css = this._rss;
      this._displayMin = "#restMin";
      this._displaySec = "#restSec";
      this.resetDisplay("work");
      break;
  }
  this._longAudioPlayed=0; 
  
}
Clock.prototype.setTime = function(amm,ass,rmm,rss){
  this._amm = amm;
  this._ass = ass;
  this._rmm = rmm;
  this._rss = rss;
  this._cmm = this._amm;
  this._css = this._ass;
  this._displayMin = "#workMin";
  this._displaySec = "#workSec";
}

Clock.prototype.showTime = function(){
  var _mm = this._tmm;
  var _ss = this._tss;
  
  _mm = (_mm<10)?"0"+_mm:_mm;
  _ss = (_ss<10)?"0"+_ss:_ss;
  
  $(this._displayMin).html(_mm);
  $(this._displaySec).html(_ss);
}

Clock.prototype._playSound = function(alarm){
  var aud = new Audio("static/audio/"+alarm+".ogg");
  aud.play();
}

Clock.prototype.updateTimer = function(){
  var _currTime = new Date().getTime();
  var _rt = this._endTime - _currTime;
  this._tss = Math.floor((_rt/1000)%60);
  this._tmm = Math.floor((_rt/1000)/60%60);
  this.showTime();
 
  if(this._tmm<=0){
    if(this._runTime>=10000){
        if(this._tss<9 && !this._longAudioPlayed){
            this._playSound("long-alarm");
            this._longAudioPlayed=1;
        }
    } 
    if(this._tss<=0){
        this._tmm=-999;
        this._tss=-999;
        switch(this._currentClock){
            case 0:
                this._currentClock = 1;
                break;
            case 1:
                this._currentClock = 0;
                break;
        }
        if(this._runTime<10000){
            this._playSound("one-sec-alarm");
        }
        clearInterval(this._timer);
        this.changeCurrentClock();
        this.runTimer();
    }
  }
}

Clock.prototype.runTimer = function(){
    var updateTimer = this.updateTimer.bind(this);
    this._runTime = (this._cmm*60+this._css)*1000;
    this._startTime = new Date().getTime();
    this._endTime = this._startTime + this._runTime;
    this._timer = setInterval(function(){
        updateTimer();
    },100);
  
}

Clock.prototype._unpauseClock = function(){
  var updateTimer = this.updateTimer.bind(this);
  this._endTime += this._pauseDuration;
  this._timer = setInterval(function(){
    updateTimer();
  },100);
}

Clock.prototype.pauseClock = function(){
  switch(this._currentClock){
    case 0:    
      if(!this._clockPaused){
        this._pauseBegin = new Date().getTime();
        this._clockPaused = 1;
        clearInterval(this._timer);
      }
      else{
        this._pauseEnd = new Date().getTime();
        this._pauseDuration = this._pauseEnd - this._pauseBegin;
        this._unpauseClock();
        this._pauseDuration = 0;
        this._pauseEnd = 0;
        this._pauseBegin = 0;
        this._clockPaused = 0;
      }
      break;
    case 1:
      alert("!You serious bro?? Trying to pause the rest Clock? Damn!!!");
      break;
  }
}
Clock.prototype.stopTimer = function(){
  if(this._timer){
    clearInterval(this._timer);
    this._timer='';
    this._longAudioPlayed = 0;
  }
  else{
    alert("No timer is running!");
  }
}
Clock.prototype.getClockTimer = function(){
    return this._timer;
}
//////**** Clock logic ends ****//////

var myClock = new Clock();

$("#setClocks").on("click",function(){
  var _amm = Number($("#amin").val());
  var _ass = Number($("#asec").val());
  var _rmm = Number($("#rmin").val());
  var _rss = Number($("#rsec").val());
  
  myClock.setTime(_amm,_ass,_rmm,_rss);
  myClock.resetDisplay("work");
  myClock.resetDisplay("rest");
});

$("#run").on("click",function(){
  if(!myClock.getClockTimer()){
    myClock.runTimer();
  }
  else{
    alert("A timer is already running!");
  }
});

$("#pause").on("click",function(){
  myClock.pauseClock();
});

$("#stop").on("click",function(){
  myClock.stopTimer();
})
