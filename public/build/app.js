(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_app_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/app.scss */ "./assets/styles/app.scss");
/* harmony import */ var _filter_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./filter.js */ "./assets/filter.js");
/* harmony import */ var _filter_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_filter_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _script_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./script.js */ "./assets/script.js");
/* harmony import */ var _script_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_script_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _bouteilles_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./bouteilles.js */ "./assets/bouteilles.js");
/* harmony import */ var _bouteilles_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_bouteilles_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _cave_perso_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./cave-perso.js */ "./assets/cave-perso.js");
/* harmony import */ var _cave_perso_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_cave_perso_js__WEBPACK_IMPORTED_MODULE_4__);
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */





console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

/***/ }),

/***/ "./assets/bouteilles.js":
/*!******************************!*\
  !*** ./assets/bouteilles.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.error.cause.js */ "./node_modules/core-js/modules/es.error.cause.js");
__webpack_require__(/*! core-js/modules/es.error.to-string.js */ "./node_modules/core-js/modules/es.error.to-string.js");
__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/es.parse-int.js */ "./node_modules/core-js/modules/es.parse-int.js");
__webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
__webpack_require__(/*! core-js/modules/esnext.iterator.constructor.js */ "./node_modules/core-js/modules/esnext.iterator.constructor.js");
__webpack_require__(/*! core-js/modules/esnext.iterator.for-each.js */ "./node_modules/core-js/modules/esnext.iterator.for-each.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
// Gestion AJAX du stock cave (boutons + et -)
document.addEventListener('DOMContentLoaded', function () {
  // Ajout de bouteille à la cave (boutons sur page bouteilles)
  var addButtons = document.querySelectorAll('.ajouter-cave');
  addButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      var _this = this;
      var bouteilleId = this.dataset.id;
      var csrfToken = this.dataset.token;
      if (!bouteilleId || !csrfToken) return;
      fetch("/cave/ajouter/".concat(bouteilleId), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: "_token=".concat(encodeURIComponent(csrfToken))
      }).then(function (response) {
        if (!response.ok) throw new Error("Erreur HTTP: ".concat(response.status));
        return response.text();
      }).then(function () {
        _this.textContent = "Ajoutée ✔️";
        _this.disabled = true;
        _this.classList.add("ajoutee");
      })["catch"](function (error) {
        alert("Une erreur est survenue : " + error.message);
      });
    });
  });

  // Gestion AJAX + et - sur la page cave perso
  function updateStockTotal() {
    var total = 0;
    document.querySelectorAll('.stock-quantite').forEach(function (span) {
      total += parseInt(span.textContent, 10) || 0;
    });
    var totalSpan = document.querySelector('.stock-total .stock-total-value');
    if (totalSpan) {
      totalSpan.textContent = total;
    }
  }
  document.querySelectorAll('.stock-actions').forEach(function (actions) {
    var btnPlus = actions.querySelector('.btn-increment');
    var btnMoins = actions.querySelector('.btn-decrement');
    var stockSpan = actions.querySelector('.stock-quantite');
    if (btnPlus) {
      btnPlus.addEventListener('click', function (e) {
        e.preventDefault();
        var url = this.dataset.url;
        var token = this.dataset.token;
        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: "_token=".concat(encodeURIComponent(token))
        }).then(function (r) {
          return r.json();
        }).then(function (data) {
          if (data.success && stockSpan) {
            stockSpan.textContent = data.quantite;
            updateStockTotal();
          }
        });
      });
    }
    if (btnMoins) {
      btnMoins.addEventListener('click', function (e) {
        e.preventDefault();
        var url = this.dataset.url;
        var token = this.dataset.token;
        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: "_token=".concat(encodeURIComponent(token))
        }).then(function (r) {
          return r.json();
        }).then(function (data) {
          if (data.success && stockSpan) {
            stockSpan.textContent = data.quantite;
            updateStockTotal();
          }
        });
      });
    }
  });
});

/***/ }),

/***/ "./assets/cave-perso.js":
/*!******************************!*\
  !*** ./assets/cave-perso.js ***!
  \******************************/
/***/ (() => {

// MODALE REPONSE COMMENTAIRE
function ouvrirModal(caveId, commentaireId) {
  var modal = document.getElementById('modal-reponse');
  var form = document.getElementById('form-reponse');
  form.action = '/cave/' + caveId + '/repondre/' + commentaireId;
  modal.style.display = 'block';
}
function fermerModal() {
  var modal = document.getElementById('modal-reponse');
  modal.style.display = 'none';
}
window.ouvrirModal = ouvrirModal;
window.fermerModal = fermerModal;

/***/ }),

/***/ "./assets/filter.js":
/*!**************************!*\
  !*** ./assets/filter.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
__webpack_require__(/*! core-js/modules/esnext.iterator.constructor.js */ "./node_modules/core-js/modules/esnext.iterator.constructor.js");
__webpack_require__(/*! core-js/modules/esnext.iterator.for-each.js */ "./node_modules/core-js/modules/esnext.iterator.for-each.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
// Sélecteur de pays et de région
// Chargement des régions en fonction du pays sélectionné
document.addEventListener('DOMContentLoaded', function () {
  var paysSelect = document.querySelector('.filter-pays');
  var regionSelect = document.querySelector('.filter-region');
  var loadRegions = function loadRegions(paysId) {
    var selectedRegionId = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    regionSelect.innerHTML = '<option value="">Toutes les régions</option>';
    if (paysId) {
      fetch("/get-regions?paysId=".concat(paysId), {
        method: 'GET',
        headers: {
          'Accept': 'application/json'
        }
      }).then(function (response) {
        return response.json();
      }).then(function (data) {
        data.regions.forEach(function (region) {
          var option = document.createElement('option');
          option.value = region.id;
          option.textContent = region.nom;
          if (selectedRegionId && region.id == selectedRegionId) {
            option.selected = true;
          }
          regionSelect.appendChild(option);
        });
      })["catch"](function (error) {
        return console.error('Erreur lors du chargement des régions:', error);
      });
    }
  };
  if (paysSelect && regionSelect) {
    // Gestion du changement de pays
    paysSelect.addEventListener('change', function () {
      loadRegions(this.value);
    });

    // Pré-remplir les régions si un pays est sélectionné au chargement
    var selectedPaysId = paysSelect.value;
    var selectedRegionId = regionSelect.dataset.selected;
    if (selectedPaysId) {
      loadRegions(selectedPaysId, selectedRegionId);
    }
  }
});

/***/ }),

/***/ "./assets/script.js":
/*!**************************!*\
  !*** ./assets/script.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/web.timers.js */ "./node_modules/core-js/modules/web.timers.js");
//Menu
document.addEventListener('DOMContentLoaded', function () {
  var burger = document.querySelector('.burger');
  var navbar = document.querySelector('.navbar');
  if (burger) {
    burger.addEventListener('click', function () {
      navbar.classList.toggle('open');
    });
  }
});

// MODALE FLASH

function fermerModale() {
  var modale = document.getElementById('modale-flash');
  if (modale) {
    modale.style.display = 'none';
  }
}

// Fermer automatiquement après 2 secondes
setTimeout(function () {
  fermerModale();
}, 2000);

// Bouton scroll top
var scrollBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', function () {
  if (window.scrollY > 200) {
    scrollBtn.style.display = 'flex';
  } else {
    scrollBtn.style.display = 'none';
  }
});
scrollBtn.addEventListener('click', function () {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

/***/ }),

/***/ "./assets/styles/app.scss":
/*!********************************!*\
  !*** ./assets/styles/app.scss ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_for-each_js-node_modules_core-js_modules_es_err-51a281"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QyxZQUFZQSxDQUFBLEVBQUc7RUFDbEIsSUFBTUMsTUFBTSxHQUFHbEYsUUFBUSxDQUFDcUQsY0FBYyxDQUFDLGNBQWMsQ0FBQztFQUN0RCxJQUFJNkIsTUFBTSxFQUFFO0lBQ1JBLE1BQU0sQ0FBQzFCLEtBQUssQ0FBQ0MsT0FBTyxHQUFHLE1BQU07RUFDakM7QUFDSjs7QUFFQTtBQUNBMEIsVUFBVSxDQUFDLFlBQU07RUFDYkYsWUFBWSxDQUFDLENBQUM7QUFDbEIsQ0FBQyxFQUFFLElBQUksQ0FBQzs7QUFFVjtBQUNBLElBQU1HLFNBQVMsR0FBR3BGLFFBQVEsQ0FBQ3FELGNBQWMsQ0FBQyxjQUFjLENBQUM7QUFDekRNLE1BQU0sQ0FBQzFELGdCQUFnQixDQUFDLFFBQVEsRUFBRSxZQUFXO0VBQzNDLElBQUkwRCxNQUFNLENBQUMwQixPQUFPLEdBQUcsR0FBRyxFQUFFO0lBQ3RCRCxTQUFTLENBQUM1QixLQUFLLENBQUNDLE9BQU8sR0FBRyxNQUFNO0VBQ3BDLENBQUMsTUFBTTtJQUNIMkIsU0FBUyxDQUFDNUIsS0FBSyxDQUFDQyxPQUFPLEdBQUcsTUFBTTtFQUNwQztBQUNGLENBQUMsQ0FBQztBQUNGMkIsU0FBUyxDQUFDbkYsZ0JBQWdCLENBQUMsT0FBTyxFQUFFLFlBQVc7RUFDN0MwRCxNQUFNLENBQUMyQixRQUFRLENBQUM7SUFBRUMsR0FBRyxFQUFFLENBQUM7SUFBRUMsUUFBUSxFQUFFO0VBQVMsQ0FBQyxDQUFDO0FBQ2pELENBQUMsQ0FBQyxDOzs7Ozs7Ozs7Ozs7QUN0Q0YiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9ib3V0ZWlsbGVzLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9jYXZlLXBlcnNvLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9maWx0ZXIuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3NjcmlwdC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5zY3NzIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXHJcbiAqIFdlbGNvbWUgdG8geW91ciBhcHAncyBtYWluIEphdmFTY3JpcHQgZmlsZSFcclxuICpcclxuICogVGhpcyBmaWxlIHdpbGwgYmUgaW5jbHVkZWQgb250byB0aGUgcGFnZSB2aWEgdGhlIGltcG9ydG1hcCgpIFR3aWcgZnVuY3Rpb24sXHJcbiAqIHdoaWNoIHNob3VsZCBhbHJlYWR5IGJlIGluIHlvdXIgYmFzZS5odG1sLnR3aWcuXHJcbiAqL1xyXG5pbXBvcnQgJy4vc3R5bGVzL2FwcC5zY3NzJztcclxuaW1wb3J0ICcuL2ZpbHRlci5qcyc7XHJcbmltcG9ydCAnLi9zY3JpcHQuanMnO1xyXG5pbXBvcnQgJy4vYm91dGVpbGxlcy5qcyc7XHJcbmltcG9ydCAnLi9jYXZlLXBlcnNvLmpzJztcclxuXHJcbmNvbnNvbGUubG9nKCdUaGlzIGxvZyBjb21lcyBmcm9tIGFzc2V0cy9hcHAuanMgLSB3ZWxjb21lIHRvIEFzc2V0TWFwcGVyISDwn46JJyk7XHJcblxyXG5cclxuXHJcblxyXG5cclxuXHJcblxyXG5cclxuIiwiLy8gR2VzdGlvbiBBSkFYIGR1IHN0b2NrIGNhdmUgKGJvdXRvbnMgKyBldCAtKVxyXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24gKCkge1xyXG4gICAgLy8gQWpvdXQgZGUgYm91dGVpbGxlIMOgIGxhIGNhdmUgKGJvdXRvbnMgc3VyIHBhZ2UgYm91dGVpbGxlcylcclxuICAgIGNvbnN0IGFkZEJ1dHRvbnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuYWpvdXRlci1jYXZlJyk7XHJcbiAgICBhZGRCdXR0b25zLmZvckVhY2goYnV0dG9uID0+IHtcclxuICAgICAgICBidXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIGNvbnN0IGJvdXRlaWxsZUlkID0gdGhpcy5kYXRhc2V0LmlkO1xyXG4gICAgICAgICAgICBjb25zdCBjc3JmVG9rZW4gPSB0aGlzLmRhdGFzZXQudG9rZW47XHJcbiAgICAgICAgICAgIGlmICghYm91dGVpbGxlSWQgfHwgIWNzcmZUb2tlbikgcmV0dXJuO1xyXG4gICAgICAgICAgICBmZXRjaChgL2NhdmUvYWpvdXRlci8ke2JvdXRlaWxsZUlkfWAsIHtcclxuICAgICAgICAgICAgICAgIG1ldGhvZDogJ1BPU1QnLFxyXG4gICAgICAgICAgICAgICAgaGVhZGVyczoge1xyXG4gICAgICAgICAgICAgICAgICAgICdDb250ZW50LVR5cGUnOiAnYXBwbGljYXRpb24veC13d3ctZm9ybS11cmxlbmNvZGVkJyxcclxuICAgICAgICAgICAgICAgICAgICAnWC1SZXF1ZXN0ZWQtV2l0aCc6ICdYTUxIdHRwUmVxdWVzdCdcclxuICAgICAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgICAgICBib2R5OiBgX3Rva2VuPSR7ZW5jb2RlVVJJQ29tcG9uZW50KGNzcmZUb2tlbil9YFxyXG4gICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAudGhlbihyZXNwb25zZSA9PiB7XHJcbiAgICAgICAgICAgICAgICBpZiAoIXJlc3BvbnNlLm9rKSB0aHJvdyBuZXcgRXJyb3IoYEVycmV1ciBIVFRQOiAke3Jlc3BvbnNlLnN0YXR1c31gKTtcclxuICAgICAgICAgICAgICAgIHJldHVybiByZXNwb25zZS50ZXh0KCk7XHJcbiAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgIC50aGVuKCgpID0+IHtcclxuICAgICAgICAgICAgICAgIHRoaXMudGV4dENvbnRlbnQgPSBcIkFqb3V0w6llIOKclO+4j1wiO1xyXG4gICAgICAgICAgICAgICAgdGhpcy5kaXNhYmxlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICB0aGlzLmNsYXNzTGlzdC5hZGQoXCJham91dGVlXCIpO1xyXG4gICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAuY2F0Y2goZXJyb3IgPT4ge1xyXG4gICAgICAgICAgICAgICAgYWxlcnQoXCJVbmUgZXJyZXVyIGVzdCBzdXJ2ZW51ZSA6IFwiICsgZXJyb3IubWVzc2FnZSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfSk7XHJcblxyXG4gICAgLy8gR2VzdGlvbiBBSkFYICsgZXQgLSBzdXIgbGEgcGFnZSBjYXZlIHBlcnNvXHJcbiAgICBmdW5jdGlvbiB1cGRhdGVTdG9ja1RvdGFsKCkge1xyXG4gICAgICAgIGxldCB0b3RhbCA9IDA7XHJcbiAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLnN0b2NrLXF1YW50aXRlJykuZm9yRWFjaChzcGFuID0+IHtcclxuICAgICAgICAgICAgdG90YWwgKz0gcGFyc2VJbnQoc3Bhbi50ZXh0Q29udGVudCwgMTApIHx8IDA7XHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgY29uc3QgdG90YWxTcGFuID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnN0b2NrLXRvdGFsIC5zdG9jay10b3RhbC12YWx1ZScpO1xyXG4gICAgICAgIGlmICh0b3RhbFNwYW4pIHtcclxuICAgICAgICAgICAgdG90YWxTcGFuLnRleHRDb250ZW50ID0gdG90YWw7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG5cclxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zdG9jay1hY3Rpb25zJykuZm9yRWFjaChhY3Rpb25zID0+IHtcclxuICAgICAgICBjb25zdCBidG5QbHVzID0gYWN0aW9ucy5xdWVyeVNlbGVjdG9yKCcuYnRuLWluY3JlbWVudCcpO1xyXG4gICAgICAgIGNvbnN0IGJ0bk1vaW5zID0gYWN0aW9ucy5xdWVyeVNlbGVjdG9yKCcuYnRuLWRlY3JlbWVudCcpO1xyXG4gICAgICAgIGNvbnN0IHN0b2NrU3BhbiA9IGFjdGlvbnMucXVlcnlTZWxlY3RvcignLnN0b2NrLXF1YW50aXRlJyk7XHJcbiAgICAgICAgaWYgKGJ0blBsdXMpIHtcclxuICAgICAgICAgICAgYnRuUGx1cy5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICBjb25zdCB1cmwgPSB0aGlzLmRhdGFzZXQudXJsO1xyXG4gICAgICAgICAgICAgICAgY29uc3QgdG9rZW4gPSB0aGlzLmRhdGFzZXQudG9rZW47XHJcbiAgICAgICAgICAgICAgICBmZXRjaCh1cmwsIHtcclxuICAgICAgICAgICAgICAgICAgICBtZXRob2Q6ICdQT1NUJyxcclxuICAgICAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICdDb250ZW50LVR5cGUnOiAnYXBwbGljYXRpb24veC13d3ctZm9ybS11cmxlbmNvZGVkJyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgJ1gtUmVxdWVzdGVkLVdpdGgnOiAnWE1MSHR0cFJlcXVlc3QnXHJcbiAgICAgICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgICAgICBib2R5OiBgX3Rva2VuPSR7ZW5jb2RlVVJJQ29tcG9uZW50KHRva2VuKX1gXHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLnRoZW4ociA9PiByLmpzb24oKSlcclxuICAgICAgICAgICAgICAgIC50aGVuKGRhdGEgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MgJiYgc3RvY2tTcGFuKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0b2NrU3Bhbi50ZXh0Q29udGVudCA9IGRhdGEucXVhbnRpdGU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHVwZGF0ZVN0b2NrVG90YWwoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmIChidG5Nb2lucykge1xyXG4gICAgICAgICAgICBidG5Nb2lucy5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XHJcbiAgICAgICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgICAgICAgICBjb25zdCB1cmwgPSB0aGlzLmRhdGFzZXQudXJsO1xyXG4gICAgICAgICAgICAgICAgY29uc3QgdG9rZW4gPSB0aGlzLmRhdGFzZXQudG9rZW47XHJcbiAgICAgICAgICAgICAgICBmZXRjaCh1cmwsIHtcclxuICAgICAgICAgICAgICAgICAgICBtZXRob2Q6ICdQT1NUJyxcclxuICAgICAgICAgICAgICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICdDb250ZW50LVR5cGUnOiAnYXBwbGljYXRpb24veC13d3ctZm9ybS11cmxlbmNvZGVkJyxcclxuICAgICAgICAgICAgICAgICAgICAgICAgJ1gtUmVxdWVzdGVkLVdpdGgnOiAnWE1MSHR0cFJlcXVlc3QnXHJcbiAgICAgICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgICAgICBib2R5OiBgX3Rva2VuPSR7ZW5jb2RlVVJJQ29tcG9uZW50KHRva2VuKX1gXHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLnRoZW4ociA9PiByLmpzb24oKSlcclxuICAgICAgICAgICAgICAgIC50aGVuKGRhdGEgPT4ge1xyXG4gICAgICAgICAgICAgICAgICAgIGlmIChkYXRhLnN1Y2Nlc3MgJiYgc3RvY2tTcGFuKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHN0b2NrU3Bhbi50ZXh0Q29udGVudCA9IGRhdGEucXVhbnRpdGU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHVwZGF0ZVN0b2NrVG90YWwoKTtcclxuICAgICAgICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgfSk7XHJcbn0pOyIsIi8vIE1PREFMRSBSRVBPTlNFIENPTU1FTlRBSVJFXHJcbmZ1bmN0aW9uIG91dnJpck1vZGFsKGNhdmVJZCwgY29tbWVudGFpcmVJZCkge1xyXG4gICAgY29uc3QgbW9kYWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbW9kYWwtcmVwb25zZScpO1xyXG4gICAgY29uc3QgZm9ybSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdmb3JtLXJlcG9uc2UnKTtcclxuICAgIGZvcm0uYWN0aW9uID0gJy9jYXZlLycgKyBjYXZlSWQgKyAnL3JlcG9uZHJlLycgKyBjb21tZW50YWlyZUlkO1xyXG4gICAgbW9kYWwuc3R5bGUuZGlzcGxheSA9ICdibG9jayc7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIGZlcm1lck1vZGFsKCkge1xyXG4gICAgY29uc3QgbW9kYWwgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbW9kYWwtcmVwb25zZScpO1xyXG4gICAgbW9kYWwuc3R5bGUuZGlzcGxheSA9ICdub25lJztcclxufVxyXG53aW5kb3cub3V2cmlyTW9kYWwgPSBvdXZyaXJNb2RhbDtcclxud2luZG93LmZlcm1lck1vZGFsID0gZmVybWVyTW9kYWw7XHJcbiIsIi8vIFPDqWxlY3RldXIgZGUgcGF5cyBldCBkZSByw6lnaW9uXHJcbi8vIENoYXJnZW1lbnQgZGVzIHLDqWdpb25zIGVuIGZvbmN0aW9uIGR1IHBheXMgc8OpbGVjdGlvbm7DqVxyXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24gKCkge1xyXG4gICAgY29uc3QgcGF5c1NlbGVjdCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5maWx0ZXItcGF5cycpO1xyXG4gICAgY29uc3QgcmVnaW9uU2VsZWN0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZpbHRlci1yZWdpb24nKTtcclxuXHJcbiAgICBjb25zdCBsb2FkUmVnaW9ucyA9IChwYXlzSWQsIHNlbGVjdGVkUmVnaW9uSWQgPSBudWxsKSA9PiB7XHJcbiAgICAgICAgcmVnaW9uU2VsZWN0LmlubmVySFRNTCA9ICc8b3B0aW9uIHZhbHVlPVwiXCI+VG91dGVzIGxlcyByw6lnaW9uczwvb3B0aW9uPic7XHJcblxyXG4gICAgICAgIGlmIChwYXlzSWQpIHtcclxuICAgICAgICAgICAgZmV0Y2goYC9nZXQtcmVnaW9ucz9wYXlzSWQ9JHtwYXlzSWR9YCwge1xyXG4gICAgICAgICAgICAgICAgbWV0aG9kOiAnR0VUJyxcclxuICAgICAgICAgICAgICAgIGhlYWRlcnM6IHsgJ0FjY2VwdCc6ICdhcHBsaWNhdGlvbi9qc29uJyB9LFxyXG4gICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLnRoZW4ocmVzcG9uc2UgPT4gcmVzcG9uc2UuanNvbigpKVxyXG4gICAgICAgICAgICAgICAgLnRoZW4oZGF0YSA9PiB7XHJcbiAgICAgICAgICAgICAgICAgICAgZGF0YS5yZWdpb25zLmZvckVhY2gocmVnaW9uID0+IHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgY29uc3Qgb3B0aW9uID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnb3B0aW9uJyk7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIG9wdGlvbi52YWx1ZSA9IHJlZ2lvbi5pZDtcclxuICAgICAgICAgICAgICAgICAgICAgICAgb3B0aW9uLnRleHRDb250ZW50ID0gcmVnaW9uLm5vbTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHNlbGVjdGVkUmVnaW9uSWQgJiYgcmVnaW9uLmlkID09IHNlbGVjdGVkUmVnaW9uSWQpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9wdGlvbi5zZWxlY3RlZCA9IHRydWU7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgICAgICAgICAgICAgcmVnaW9uU2VsZWN0LmFwcGVuZENoaWxkKG9wdGlvbik7XHJcbiAgICAgICAgICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgICAgICAgICB9KVxyXG4gICAgICAgICAgICAgICAgLmNhdGNoKGVycm9yID0+IGNvbnNvbGUuZXJyb3IoJ0VycmV1ciBsb3JzIGR1IGNoYXJnZW1lbnQgZGVzIHLDqWdpb25zOicsIGVycm9yKSk7XHJcbiAgICAgICAgfVxyXG4gICAgfTtcclxuXHJcbiAgICBpZiAocGF5c1NlbGVjdCAmJiByZWdpb25TZWxlY3QpIHtcclxuICAgICAgICAvLyBHZXN0aW9uIGR1IGNoYW5nZW1lbnQgZGUgcGF5c1xyXG4gICAgICAgIHBheXNTZWxlY3QuYWRkRXZlbnRMaXN0ZW5lcignY2hhbmdlJywgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICBsb2FkUmVnaW9ucyh0aGlzLnZhbHVlKTtcclxuICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgLy8gUHLDqS1yZW1wbGlyIGxlcyByw6lnaW9ucyBzaSB1biBwYXlzIGVzdCBzw6lsZWN0aW9ubsOpIGF1IGNoYXJnZW1lbnRcclxuICAgICAgICBjb25zdCBzZWxlY3RlZFBheXNJZCA9IHBheXNTZWxlY3QudmFsdWU7XHJcbiAgICAgICAgY29uc3Qgc2VsZWN0ZWRSZWdpb25JZCA9IHJlZ2lvblNlbGVjdC5kYXRhc2V0LnNlbGVjdGVkO1xyXG5cclxuICAgICAgICBpZiAoc2VsZWN0ZWRQYXlzSWQpIHtcclxuICAgICAgICAgICAgbG9hZFJlZ2lvbnMoc2VsZWN0ZWRQYXlzSWQsIHNlbGVjdGVkUmVnaW9uSWQpO1xyXG4gICAgICAgIH1cclxuICAgIH1cclxufSk7XHJcbiIsIi8vTWVudVxyXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgKCkgPT4ge1xyXG4gIGNvbnN0IGJ1cmdlciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5idXJnZXInKTtcclxuICBjb25zdCBuYXZiYXIgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcubmF2YmFyJyk7XHJcblxyXG4gIGlmIChidXJnZXIpIHtcclxuICAgIGJ1cmdlci5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcclxuICAgICAgbmF2YmFyLmNsYXNzTGlzdC50b2dnbGUoJ29wZW4nKTtcclxuICAgIH0pO1xyXG4gIH1cclxufSk7XHJcblxyXG5cclxuLy8gTU9EQUxFIEZMQVNIXHJcblxyXG5mdW5jdGlvbiBmZXJtZXJNb2RhbGUoKSB7XHJcbiAgICAgIGNvbnN0IG1vZGFsZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtb2RhbGUtZmxhc2gnKTtcclxuICAgICAgaWYgKG1vZGFsZSkge1xyXG4gICAgICAgICAgbW9kYWxlLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XHJcbiAgICAgIH1cclxuICB9XHJcblxyXG4gIC8vIEZlcm1lciBhdXRvbWF0aXF1ZW1lbnQgYXByw6hzIDIgc2Vjb25kZXNcclxuICBzZXRUaW1lb3V0KCgpID0+IHtcclxuICAgICAgZmVybWVyTW9kYWxlKCk7XHJcbiAgfSwgMjAwMCk7XHJcblxyXG4vLyBCb3V0b24gc2Nyb2xsIHRvcFxyXG5jb25zdCBzY3JvbGxCdG4gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnc2Nyb2xsVG9wQnRuJyk7XHJcbndpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdzY3JvbGwnLCBmdW5jdGlvbigpIHtcclxuICBpZiAod2luZG93LnNjcm9sbFkgPiAyMDApIHtcclxuICAgICAgc2Nyb2xsQnRuLnN0eWxlLmRpc3BsYXkgPSAnZmxleCc7XHJcbiAgfSBlbHNlIHtcclxuICAgICAgc2Nyb2xsQnRuLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XHJcbiAgfVxyXG59KTtcclxuc2Nyb2xsQnRuLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oKSB7XHJcbiAgd2luZG93LnNjcm9sbFRvKHsgdG9wOiAwLCBiZWhhdmlvcjogJ3Ntb290aCcgfSk7XHJcbn0pOyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJjb25zb2xlIiwibG9nIiwiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiYWRkQnV0dG9ucyIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJmb3JFYWNoIiwiYnV0dG9uIiwiX3RoaXMiLCJib3V0ZWlsbGVJZCIsImRhdGFzZXQiLCJpZCIsImNzcmZUb2tlbiIsInRva2VuIiwiZmV0Y2giLCJjb25jYXQiLCJtZXRob2QiLCJoZWFkZXJzIiwiYm9keSIsImVuY29kZVVSSUNvbXBvbmVudCIsInRoZW4iLCJyZXNwb25zZSIsIm9rIiwiRXJyb3IiLCJzdGF0dXMiLCJ0ZXh0IiwidGV4dENvbnRlbnQiLCJkaXNhYmxlZCIsImNsYXNzTGlzdCIsImFkZCIsImVycm9yIiwiYWxlcnQiLCJtZXNzYWdlIiwidXBkYXRlU3RvY2tUb3RhbCIsInRvdGFsIiwic3BhbiIsInBhcnNlSW50IiwidG90YWxTcGFuIiwicXVlcnlTZWxlY3RvciIsImFjdGlvbnMiLCJidG5QbHVzIiwiYnRuTW9pbnMiLCJzdG9ja1NwYW4iLCJlIiwicHJldmVudERlZmF1bHQiLCJ1cmwiLCJyIiwianNvbiIsImRhdGEiLCJzdWNjZXNzIiwicXVhbnRpdGUiLCJvdXZyaXJNb2RhbCIsImNhdmVJZCIsImNvbW1lbnRhaXJlSWQiLCJtb2RhbCIsImdldEVsZW1lbnRCeUlkIiwiZm9ybSIsImFjdGlvbiIsInN0eWxlIiwiZGlzcGxheSIsImZlcm1lck1vZGFsIiwid2luZG93IiwicGF5c1NlbGVjdCIsInJlZ2lvblNlbGVjdCIsImxvYWRSZWdpb25zIiwicGF5c0lkIiwic2VsZWN0ZWRSZWdpb25JZCIsImFyZ3VtZW50cyIsImxlbmd0aCIsInVuZGVmaW5lZCIsImlubmVySFRNTCIsInJlZ2lvbnMiLCJyZWdpb24iLCJvcHRpb24iLCJjcmVhdGVFbGVtZW50IiwidmFsdWUiLCJub20iLCJzZWxlY3RlZCIsImFwcGVuZENoaWxkIiwic2VsZWN0ZWRQYXlzSWQiLCJidXJnZXIiLCJuYXZiYXIiLCJ0b2dnbGUiLCJmZXJtZXJNb2RhbGUiLCJtb2RhbGUiLCJzZXRUaW1lb3V0Iiwic2Nyb2xsQnRuIiwic2Nyb2xsWSIsInNjcm9sbFRvIiwidG9wIiwiYmVoYXZpb3IiXSwic291cmNlUm9vdCI6IiJ9