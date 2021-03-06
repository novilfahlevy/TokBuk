const initJsSelect2 = (selectClass, options = {}) => $(`.${selectClass}`).select2(options);
const format = (number, currency = 'IDR') => {
  if ( currency ) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency }).format(number);
  } else {
    return new Intl.NumberFormat('id-ID').format(number);
  }
}

function disableCtryKeys(event, ...keys) {
  const key = event.which || event.keyCode;

  if ( event.ctrlKey && keys.includes(key) ) {
    switch ( key ) {
      case 83 :
        event.preventDefault();
        event.stopPropagation();
        return true;
      break;
    }
  }
}

function delayEvent(callback, time) {
  let timer = 0;
  return function() {
    const self = this;
    const args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function() {
      callback.apply(self, args);
    }, time);
  }
}