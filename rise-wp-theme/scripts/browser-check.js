function isUnsupported(browser) {
  return browser.name === 'MSIE' || browser.name === 'IE';
}

// Uncomment to simulate being in an IE browser.

listen('load', window, function () {
  if (isUnsupported(get_browser())) {
    const { origin } = window.location;
    const url = `${origin}/unsupported.html`;
    window.location.replace(url);
  }
});
// eslint-disable-next-line consistent-return
function listen(evnt, elem, func) {
  if (elem.addEventListener) {
    // W3C DOM
    elem.addEventListener(evnt, func, false);
  } else if (elem.attachEvent) {
    // IE DOM
    // eslint-disable-next-line vars-on-top
    var r = elem.attachEvent('on' + evnt, func);
    return r;
    // eslint-disable-next-line no-alert
  } else window.alert('Error: unsupported browser!');
}
function get_browser() {
  let ua = navigator.userAgent,
    version,
    matchList =
      ua.match(
        /(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i
      ) || [];
  if (/trident/i.test(matchList[1])) {
    version = /\brv[ :]+(\d+)/g.exec(ua) || [];
    return { name: 'IE', version: version[1] || '' };
  }
  if (matchList[1] === 'Chrome') {
    version = ua.match(/\bOPR\/(\d+)/);
    if (version != null) {
      return { name: 'Opera', version: version[1] };
    }
  }
  if (window.navigator.userAgent.indexOf('Edge') > -1) {
    // eslint-disable-next-line no-useless-escape
    version = ua.match(/\Edge\/(\d+)/);
    if (version != null) {
      return { name: 'Edge', version: version[1] };
    }
  }
  matchList = matchList[2]
    ? [matchList[1], matchList[2]]
    : [navigator.appName, navigator.appVersion, '-?'];
  if ((version = ua.match(/version\/(\d+)/i)) != null) {
    matchList.splice(1, 1, version[1]);
  }
  return {
    name: matchList[0],
    version: +matchList[1],
  };
}
