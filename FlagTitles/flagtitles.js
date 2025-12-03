var FlagTitles = {};

FlagTitles.localMode = false;
FlagTitles.localURL = '';
FlagTitles.remoteURL = 'https://restcountries.com/v3.1/all?fields=name,cca2,idd';

FlagTitles.flagToCode = function(flag) {
  return Array.from(flag)
    .map(ch => String.fromCharCode(ch.codePointAt(0) - 0x1F1E6 + 65))
    .join('');
}

FlagTitles.fetchFlags = async function () {
  // Fetch all country codes and names
  let countryMap = {};
  try {
    const res = await fetch(FlagTitles.localMode ? FlagTitles.localURL : FlagTitles.remoteURL);
    const countries = await res.json();
    countries.forEach(c => {
      if (c.cca2 && c.name?.common) {
        countryMap[c.cca2.toUpperCase()] = c;
      }
    });
    FlagTitles.countryMap = countryMap;
    return countryMap;
  } catch (err) {
    console.error("Failed to load country list:", err);
  }
}

FlagTitles.fetchIfNeeded = async function () {
   if (!FlagTitles.countryMap) {
     console.log("No country map");
     FlagTitles.fetchFlags().then(data => {});
     console.log("No country map");
   }
   console.log("Fetch result failed: " + (FlagTitles.countryMap == null));
   return FlagTitles.countryMap;
}



FlagTitles.makeTooltip =  function(flag, code, country) {
    const name = country?.name?.common || FlagTitles.flagToCode(flag);
    const idd = country?.idd;
    let prefixes = "";

    if (idd?.root) {
      const suffixes = idd.suffixes?.length
        ? idd.suffixes.map(s => idd.root + s)
        : [idd.root];
      const suffixesLimited = (suffixes.length > 4)
        ? suffixes.slice(0, 4).concat("...")
        : suffixes;
      prefixes = ", \u260E" + suffixesLimited.join(", ");
    }

    return `${flag} ${name} [${code}${prefixes}]`;
}


FlagTitles.labelFlag = function(flag) {

  //if (!FlagTitles.fetchIfNeeded()) {
  //    console.log("Fetching at: " + flag);
  //    return flag;
  //}
  //console.log("Processing " + flag);
  const code = FlagTitles.flagToCode(flag);
  const country = FlagTitles.countryMap[code]
  
  // Create span with tooltip + style class
  const span = document.createElement('span');
  span.textContent = flag;
  span.title = FlagTitles.makeTooltip(flag, code, country);
  span.className = 'flag-tooltip';
  return span.outerHTML;
}

// Regex to detect two Regional Indicator Symbols (flags)
FlagTitles.flagRegex = /([\u{1F1E6}-\u{1F1FF}]{2})/gu;


FlagTitles.EXCLUDED_TAGS = new Set([
    'textarea',
    'script',
    'style',
    'template',
    'svg',
    'math'
  ]);

FlagTitles.processNode = function (node) {

  if (node.nodeType === Node.ELEMENT_NODE && FlagTitles.EXCLUDED_TAGS.has(node.nodeName.toLowerCase())) {
    return;
  }

  // Replace flags in text nodes
  if (node.nodeType === Node.TEXT_NODE) {
    const replaced = node.textContent.replace(FlagTitles.flagRegex, FlagTitles.labelFlag);
    if (replaced !== node.textContent) {
      const span = document.createElement('span');
      span.innerHTML = replaced;
      node.replaceWith(span);
    }
  } else {
    node.childNodes.forEach(FlagTitles.processNode);
  }
}

FlagTitles.process = function() {
  const el = document.getElementById('wikitext');
  if (el) {
    FlagTitles.fetchFlags().then(data => {FlagTitles.processNode(el); });
  }
}
