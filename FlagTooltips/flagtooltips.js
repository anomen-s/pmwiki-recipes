var FlagTooltips = {};

FlagTooltips.localMode = false;
FlagTooltips.localURL = '';
FlagTooltips.remoteURL = 'https://restcountries.com/v3.1/all?fields=name,cca2,idd';

FlagTooltips.flagToCode = function(flag) {
  return Array.from(flag)
    .map(ch => String.fromCharCode(ch.codePointAt(0) - 0x1F1E6 + 65))
    .join('');
}

FlagTooltips.fetchFlags = async function () {
  // Fetch all country codes and names
  let countryMap = {};
  try {
    const res = await fetch(FlagTooltips.localMode ? FlagTooltips.localURL : FlagTooltips.remoteURL);
    const countries = await res.json();
    countries.forEach(c => {
      if (c.cca2 && c.name?.common) {
        countryMap[c.cca2.toUpperCase()] = c;
      }
    });
    FlagTooltips.countryMap = countryMap;
    return countryMap;
  } catch (err) {
    console.error("Failed to load country list:", err);
  }
}

FlagTooltips.fetchIfNeeded = async function () {
   if (!FlagTooltips.countryMap) {
     console.log("No country map");
     FlagTooltips.fetchFlags().then(data => {});
     console.log("No country map");
   }
   console.log("Fetch result failed: " + (FlagTooltips.countryMap == null));
   return FlagTooltips.countryMap;
}



FlagTooltips.makeTooltip =  function(flag, code, country) {
    const name = country?.name?.common || FlagTooltips.flagToCode(flag);
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


FlagTooltips.labelFlag = function(flag) {

  //if (!FlagTooltips.fetchIfNeeded()) {
  //    console.log("Fetching at: " + flag);
  //    return flag;
  //}
  //console.log("Processing " + flag);
  const code = FlagTooltips.flagToCode(flag);
  const country = FlagTooltips.countryMap[code]
  
  // Create span with tooltip + style class
  const span = document.createElement('span');
  span.textContent = flag;
  span.title = FlagTooltips.makeTooltip(flag, code, country);
  span.className = 'flag-tooltip';
  return span.outerHTML;
}

// Regex to detect two Regional Indicator Symbols (flags)
FlagTooltips.flagRegex = /([\u{1F1E6}-\u{1F1FF}]{2})/gu;


FlagTooltips.EXCLUDED_TAGS = new Set([
    'textarea',
    'script',
    'style',
    'template',
    'svg',
    'math'
  ]);

FlagTooltips.processNode = function (node) {

  if (node.nodeType === Node.ELEMENT_NODE && FlagTooltips.EXCLUDED_TAGS.has(node.nodeName.toLowerCase())) {
    return;
  }

  // Replace flags in text nodes
  if (node.nodeType === Node.TEXT_NODE) {
    const replaced = node.textContent.replace(FlagTooltips.flagRegex, FlagTooltips.labelFlag);
    if (replaced !== node.textContent) {
      const span = document.createElement('span');
      span.innerHTML = replaced;
      node.replaceWith(span);
    }
  } else {
    node.childNodes.forEach(FlagTooltips.processNode);
  }
}

FlagTooltips.process = function() {
  const el = document.getElementById('wikitext');
  if (el) {
    FlagTooltips.fetchFlags().then(data => {FlagTooltips.processNode(el); });
  }
}
