<!doctype html>
<html lang="fr" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Polyxams - Centre de Révisions</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Nunito', sans-serif; box-sizing: border-box; }
    .gradient-bg { background: linear-gradient(135deg, #FEF3C7 0%, #FBBF24 50%, #F97316 100%); }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(249, 115, 22, 0.35); }
    .tab-active { background: linear-gradient(135deg, #F97316, #DC2626); color: white; box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.4); }
    
    /* Thèmes de contenu */
    .view-lecon { border-left: 10px solid #F59E0B; }
    .view-exercice { border-top: 10px solid #EF4444; }
    .view-astuce { background: linear-gradient(135deg, #6366F1 0%, #A855F7 100%); color: white; border-radius: 1.5rem; }
    
    /* Style QCM */
    .qcm-option {
      display: block; width: 100%; padding: 1.2rem; margin-bottom: 0.75rem;
      background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 0.75rem;
      text-align: left; transition: all 0.2s; cursor: pointer;
    }
    .qcm-option:hover:not(:disabled) { border-color: #f97316; background: #fff7ed; }
    .qcm-option.correct { border-color: #22c55e; background: #f0fdf4; color: #166534; font-weight: bold; }
    .qcm-option.wrong { border-color: #ef4444; background: #fef2f2; color: #991b1b; }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-in { animation: fadeInUp 0.4s ease-out forwards; }
  </style>
</head>
<body class="h-full bg-amber-50">

  <div id="app" class="min-h-full flex flex-col">
    <header class="gradient-bg py-12 px-4 text-center relative overflow-hidden">
      <h1 class="flex items-center justify-center gap-4 text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg mb-2">
  <img src="polyxams-logo.png" alt="Polyxams logo" class="w-16 md:w-20 object-contain" width="160">
  <span>Polyxams</span>
</h1>
      <p class="text-orange-100 font-medium">L'excellence pour votre Brevet et Baccalauréat</p>
    </header>

    <div id="ui-navigation">
      <nav class="max-w-6xl mx-auto px-4 -mt-6 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl p-2 flex flex-wrap justify-center gap-2">
        <button onclick="selectLevel('3eme')" id="btn-3eme" class="tab-active px-6 py-3 rounded-xl font-bold text-sm md:text-base transition-all duration-300 flex items-center gap-2" src="${lecon.icon}"><img src="blue.png" alt="copybook blue" border="0" width="60" class="flex items-center">3ème - Brevet</button> 
        <button onclick="selectLevel('premiere')" id="btn-premiere" class="px-6 py-3 rounded-xl font-bold text-sm md:text-base text-gray-600 hover:bg-orange-100 transition-all duration-300 flex items-center gap-2"><img src="red.png" alt="copybook red" border="0" width="60" class="flex items-center"></img>Première</button> 
        <button onclick="selectLevel('terminale')" id="btn-terminale" class="px-6 py-3 rounded-xl font-bold text-sm md:text-base text-gray-600 hover:bg-orange-100 transition-all duration-300 flex items-center gap-2"><img src="green.png" alt="copybook green" border="0" width="60" class="flex items-center">Terminale - Bac</button>
    </div>
      </nav>

      <div class="max-w-6xl mx-auto px-4 mt-8 flex flex-wrap justify-center gap-3">
        <button onclick="filterContent('all')" id="filter-all" class="bg-orange-500 text-white px-5 py-2 rounded-full font-semibold text-sm shadow-md transition-all">📚 Tout voir</button>
        <button onclick="filterContent('lecons')" id="filter-lecons" class="bg-white text-gray-600 px-5 py-2 rounded-full font-semibold text-sm shadow hover:shadow-md transition-all">📖 Leçons</button>
        <button onclick="filterContent('exercices')" id="filter-exercices" class="bg-white text-gray-600 px-5 py-2 rounded-full font-semibold text-sm shadow hover:shadow-md transition-all">✏️ Exercices</button>
        <button onclick="filterContent('astuces')" id="filter-astuces" class="bg-white text-gray-600 px-5 py-2 rounded-full font-semibold text-sm shadow hover:shadow-md transition-all">💡 Astuces</button>
      </div>
    </div>

    <main id="ui-grid" class="max-w-6xl mx-auto px-4 py-8">
      <div id="content-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        </div>
    </main>

    <section id="ui-detail" class="hidden max-w-4xl mx-auto px-4 py-8 animate-in">
      <button onclick="closeDetail()" class="mb-6 flex items-center gap-2 text-orange-600 font-bold hover:translate-x-[-5px] transition-transform">
        ← Retour aux choix
      </button>
      <div id="detail-card" class="bg-white p-8 shadow-2xl rounded-3xl">
        <div id="detail-header" class="mb-6"></div>
        <div id="detail-body"></div>
      </div>
    </section>

    <footer class="bg-orange-600 py-6 text-center text-orange-100 text-sm mt-auto">
      <p>🚀 Polyxams : La régularité fait la différence. © 2026</p>
    </footer>
  </div>

  <script>
    // ============================================================
    // ⬇️ MODIFIEZ VOS DONNÉES ICI ⬇️
    // ============================================================
    const contentData = {
      "3eme": {
        lecons: [
          { 
            title: "Théorème de Pythagore", 
            subject: "Mathématiques", 
            description: "Apprenez à calculer les longueurs dans un triangle rectangle.", 
            icon: "maths.png",
            fullText: "Dans un triangle rectangle, le carré de l'hypoténuse est égal à la somme des carrés des longueurs des deux autres côtés. Formule : BC² = AB² + AC²." 
          },
          {
            title: "La Seconde Guerre Mondiale",
            subject: "Histoire",
            description: "Les grandes phases du conflit, de 1939 à 1945, et ses conséquences sur le monde.",
            icon: "his.png",
            difficulty: "Important"
          },
          {
            title: "Les fonctions linéaires",
            subject: "Mathématiques",
            description: "Comprendre f(x) = ax et savoir tracer la représentation graphique.",
            icon: "maths.png",
            difficulty: "Facile"
          }, // ⬅️ AJOUTER AUTRES LEÇONS ICI
        ],
        exercices: [
          { 
            title: "Entraînement : Pythagore", 
            subject: "Mathématiques", 
            description: "S'entraîner avec des calculs d'hypoténuse.", 
            icon: "maths.png" 
          },
          {
            title: "Dictée - Accord du participe",
            subject: "Français",
            description: "Entraînez-vous avec cette dictée sur les accords du participe passé.",
            icon: "french.png",
            difficulty: "Difficile"
          },
          {
            title: "Carte à compléter - Europe",
            subject: "Géographie",
            description: "Placez les pays et capitales d'Europe sur la carte.",
            icon: "geo.png",
            difficulty: "Facile"
          }, // ⬅️ AJOUTER AUTRES EXERCICES ICI
        ],
        astuces: [
          { 
            title: "Réussir son Brevet", 
            subject: "Méthodologie", 
            description: "Comment gérer son temps pendant l'épreuve.", 
            icon: "",
            fullText: "Lisez tout le sujet pendant les 5 premières minutes et commencez par l'exercice où vous êtes le plus à l'aise."
          },
          {
            title: "Mémoriser les dates",
            subject: "Méthodologie",
            description: "Utilisez des moyens mnémotechniques : associez chaque date à une image ou une histoire.",
            icon: "",
            difficulty: "Astuce"
          },
          {
            title: "Rédiger une introduction",
            subject: "Français",
            description: "Structure : Accroche → Présentation du sujet → Problématique → Annonce du plan.",
            icon: "french.png",
            difficulty: "Astuce"
          },
        ]
      },
      "premiere": {
        lecons: [
          {
            title: "Les dérivées",
            subject: "Mathématiques",
            description: "Notion de nombre dérivé, fonction dérivée et applications à l'étude des variations.",
            icon: "maths.png",
            difficulty: "Important"
          },
          {
            title: "La Révolution française",
            subject: "Histoire",
            description: "De la convocation des États généraux à la chute de la monarchie (1789-1792).",
            icon: "his.png",
            difficulty: "Important"
          },
          {
            title: "Les suites numériques",
            subject: "Mathématiques",
            description: "Suites arithmétiques et géométriques : définition, formules et applications.",
            icon: "maths.png",
            difficulty: "Moyen"
          },
          { 
            title: "", 
            subject: "", 
            description: "", 
            icon: "",
            fullText: "" 
          } // ⬅️ AJOUTER AUTRES LEÇONS ICI
        ],
        exercices: [
          {
            title: "Calculs de dérivées",
            subject: "Mathématiques",
            description: "15 exercices progressifs sur le calcul des dérivées de fonctions.",
            icon: "maths.png",
            difficulty: "Moyen"
          },
          {
            title: "Commentaire littéraire",
            subject: "Français",
            description: "Analysez un extrait de Baudelaire avec la méthode du commentaire composé.",
            icon: "french.png",
            difficulty: "Difficile"
          },
          { 
            title: "", 
            subject: "", 
            description: "", 
            icon: "" 
          } // ⬅️ AJOUTER AUTRES EXERCICES ICI
        ],
        astuces: [
          {
            title: "Formules de dérivation",
            subject: "Mathématiques",
            description: "Créez des fiches avec toutes les formules : (uv)' = u'v + uv' et (u/v)' = (u'v - uv')/v²",
            icon: "maths.png",
            difficulty: "Astuce"
          },
          {
            title: "Analyser un texte",
            subject: "Français",
            description: "SPRI : Situation, Problème, Résolution, Information - pour structurer votre analyse.",
            icon: "french.png",
            difficulty: "Astuce"
          },
          { 
            title: "", 
            subject: "", 
            description: "", 
            icon: "",
            fullText: ""
          }
        ]
      },
      "terminale": {
        lecons: [
           {
            title: "Les intégrales",
            subject: "Mathématiques",
            description: "Primitives, intégrale d'une fonction continue, calcul d'aires et applications.",
            icon: "maths.png",
            difficulty: "Important"
          },
          {
            title: "La Guerre froide",
            subject: "Histoire",
            description: "De 1947 à 1991 : un monde bipolaire, les crises et la chute du bloc soviétique.",
            icon: "his.png",
            difficulty: "Important"
          },
          {
            title: "Probabilités conditionnelles",
            subject: "Mathématiques",
            description: "Probabilité conditionnelle, indépendance et formule de Bayes.",
            icon: "maths.png",
            difficulty: "Difficile"
          },
          {
            title: "Les limites de fonctions",
            subject: "Mathématiques",
            description: "Limites, formes indéterminées, asymptotes et comportement à l'infini.",
            icon: "maths.png",
            difficulty: "Moyen"
          },
          { 
            title: "", 
            subject: "", 
            description: "", 
            icon: "",
            fullText: "" 
          } // ⬅️ AJOUTER AUTRES LEÇONS ICI
        ],
        exercices: [
          {
            title: "Annales Bac - Intégrales",
            subject: "Mathématiques",
            description: "10 exercices type bac sur les intégrales avec corrigés détaillés.",
            icon: "maths.png",
            difficulty: "Difficile"
          },
          {
            title: "Dissertation philosophique",
            subject: "Philosophie",
            description: "Sujet : 'La liberté consiste-t-elle à faire ce que l'on veut ?'",
            icon: "philo.png",
            difficulty: "Difficile"
          },
          {
            title: "Grand Oral - Simulation",
            subject: "Méthodologie",
            description: "Préparez votre Grand Oral avec ces 5 sujets d'entraînement.",
            icon: "",
            difficulty: "Important"
          },
          { 
            title: "", 
            subject: "", 
            description: "", 
            icon: "" 
          } // ⬅️ AJOUTER AUTRES EXERCICES ICI
        ],
        astuces: [
          {
            title: "Réussir le Grand Oral",
            subject: "Méthodologie",
            description: "Structurez en 3 temps : Introduction percutante, Développement clair, Ouverture finale.",
            icon: "",
            difficulty: "Astuce"
          },
          {
            title: "Intégrales par parties",
            subject: "Mathématiques",
            description: "LIATE : Log, Inverse trigo, Algébrique, Trigo, Exponentielle - ordre de priorité pour u.",
            icon: "maths.png",
            difficulty: "Astuce"
          },
          {
            title: "Plan de dissertation",
            subject: "Philosophie",
            description: "Thèse → Antithèse → Synthèse : ne pas oublier de dépasser l'opposition !",
            icon: "philo.png",
            difficulty: "Astuce"
          },
          { 
            title: "", 
            subject: "", 
            description: "", 
            icon: "",
            fullText: ""
          }
        ]
      }
    };

    // ============================================================
    // ⬆️ FIN DE LA ZONE DE MODIFICATION ⬆️
    // ============================================================

    let currentLevel = "3eme";
    let currentFilter = "all";

    // Fonction d'affichage de la grille
    function renderGrid() {
  const container = document.getElementById('content-container');
  const data = contentData[currentLevel];
  let items = [];

  if (currentFilter === 'all' || currentFilter === 'lecons')
    items = items.concat(data.lecons.map(i => ({ ...i, type: 'lecon' })));

  if (currentFilter === 'all' || currentFilter === 'exercices')
    items = items.concat(data.exercices.map(i => ({ ...i, type: 'exercice' })));

  if (currentFilter === 'all' || currentFilter === 'astuces')
    items = items.concat(data.astuces.map(i => ({ ...i, type: 'astuce' })));

  container.innerHTML = items.map((item, index) => `
    <div class="card-hover bg-white rounded-2xl shadow-lg p-6 animate-in">
      
      ${item.icon ? `<img src="${item.icon}" class="w-16 h-16 object-contain mx-auto mb-3">` : ''}

      <h3 class="text-xl font-bold text-gray-800 mt-3 text-center">${item.title}</h3>
      <p class="text-orange-500 text-xs font-bold uppercase tracking-wider mb-2 text-center">${item.subject}</p>
      <p class="text-gray-500 text-sm mb-5 leading-relaxed text-center">${item.description}</p>

      <button onclick="openDetail('${item.title}', '${item.type}', '${currentLevel}')"
              class="w-full py-3 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-orange-200">
        Accéder
      </button>

    </div>
  `).join('');
}

    // Gestion de l'ouverture du détail
    function openDetail(title, type, level) {
      document.getElementById('ui-navigation').classList.add('hidden');
      document.getElementById('ui-grid').classList.add('hidden');
      const detailZone = document.getElementById('ui-detail');
      const card = document.getElementById('detail-card');
      const body = document.getElementById('detail-body');
      
      detailZone.classList.remove('hidden');
      card.className = "bg-white p-8 shadow-2xl rounded-3xl view-" + type;

      const item = contentData[level][type + 's'].find(i => i.title === title);

      if (type === 'lecon' || type === 'astuce') {
        document.getElementById('detail-header').innerHTML = `<h2 class="text-3xl font-black text-gray-800">${title}</h2>`;
        body.innerHTML = `<div class="prose max-w-none text-gray-700 text-lg leading-relaxed">${item.fullText || 'Contenu bientôt disponible...'}</div>`;
      } 
      else if (type === 'exercice') {
        generateMathExercise(title);
      }
    }

    // Générateur d'exercices Mathématiques (QCM)
    function generateMathExercise(title) {
      const a = Math.floor(Math.random() * 7) + 3; 
      const b = Math.floor(Math.random() * 7) + 4;
      const result = Math.sqrt(a*a + b*b).toFixed(1);

      document.getElementById('detail-header').innerHTML = `
        <span class="text-red-500 font-bold uppercase text-sm tracking-widest">Calcul Mental & Brouillon</span>
        <h2 class="text-3xl font-black text-gray-800">${title}</h2>`;
      
      document.getElementById('detail-body').innerHTML = `
        <div class="space-y-6">
          <div class="bg-red-50 p-6 rounded-2xl border-2 border-red-100">
            <p class="text-xl text-gray-800">Soit un triangle rectangle dont les côtés mesurent <strong>${a} cm</strong> et <strong>${b} cm</strong>.</p>
            <p class="mt-2 text-red-600 font-bold italic">💡 Calcule l'hypoténuse sur ta feuille avant de répondre !</p>
          </div>
          <div class="grid gap-3">
            <button onclick="verify(this, true)" class="qcm-option">Réponse A : ${result} cm</button>
            <button onclick="verify(this, false)" class="qcm-option">Réponse B : ${(parseFloat(result) + 1.5).toFixed(1)} cm</button>
            <button onclick="verify(this, false)" class="qcm-option">Réponse C : ${(a + b).toFixed(1)} cm</button>
          </div>
          <button onclick="generateMathExercise('${title}')" class="w-full text-gray-400 text-sm underline mt-4">🔄 Générer d'autres nombres</button>
        </div>
      `;
    }

    // Vérification des réponses
    function verify(btn, isCorrect) {
      const options = document.querySelectorAll('.qcm-option');
      options.forEach(opt => opt.disabled = true);
      
      if(isCorrect) {
        btn.classList.add('correct');
        alert("Excellent ! Tu as bien posé ton calcul.");
      } else {
        btn.classList.add('wrong');
        alert("Oups ! Vérifie si tu n'as pas oublié de mettre les nombres au carré (a² + b² = c²).");
      }
    }

    // Navigation
    function closeDetail() {
      document.getElementById('ui-navigation').classList.remove('hidden');
      document.getElementById('ui-grid').classList.remove('hidden');
      document.getElementById('ui-detail').classList.add('hidden');
    }

    function selectLevel(level) {
      currentLevel = level;
      document.querySelectorAll('[id^="btn-"]').forEach(b => b.classList.remove('tab-active'));
      document.getElementById('btn-' + level).classList.add('tab-active');
      renderGrid();
    }

    function filterContent(f) {
      currentFilter = f;
      document.querySelectorAll('[id^="filter-"]').forEach(b => {
        b.className = "bg-white text-gray-600 px-5 py-2 rounded-full font-semibold text-sm shadow hover:shadow-md transition-all";
      });
      document.getElementById('filter-' + f).className = "bg-orange-500 text-white px-5 py-2 rounded-full font-semibold text-sm shadow-md transition-all";
      renderGrid();
    }

    // Lancement initial
    renderGrid();
  </script>
</body>
</html>
