<template>
  <main class="welcome-page">
    <section class="welcome-hero">
      <div class="hero-copy">
        <p class="eyebrow"><span></span> PLATEFORME DE GESTION SCOLAIRE</p>
        <h1>Votre établissement, <span>en un seul endroit.</span></h1>
        <p class="hero-description">
          Gérez les inscriptions, les classes, les équipes pédagogiques et les paiements depuis une interface claire et
          simple à utiliser.
        </p>

        <div class="hero-actions">
          <v-btn class="primary-action" color="primary" size="large" href="#apercu" :append-icon="icons.mdiArrowDown">
            Découvrir la plateforme
          </v-btn>
          <v-btn class="login-action" variant="text" size="large" @click="goToLogin">
            Se connecter
          </v-btn>
        </div>

        <div class="hero-benefits">
          <span><v-icon :icon="icons.mdiCheckCircleOutline" size="18" /> Suivi centralisé</span>
          <span><v-icon :icon="icons.mdiCheckCircleOutline" size="18" /> Données par année scolaire</span>
        </div>
      </div>

      <div id="apercu" class="preview-wrap">
        <div class="preview-glow"></div>
        <section class="dashboard-preview" aria-label="Aperçu du tableau de bord scolaire">
          <header class="preview-topbar">
            <div class="preview-brand">
              <span class="brand-mark"><v-icon :icon="icons.mdiSchoolOutline" size="19" /></span>
              <span>Gestion scolaire</span>
            </div>
            <div class="preview-profile"><span>AD</span></div>
          </header>

          <div class="preview-content">
            <div class="preview-heading">
              <div>
                <p class="preview-label">APERÇU DE L'INTERFACE</p>
                <h2>Vue d'ensemble</h2>
              </div>
              <div class="preview-year"><v-icon :icon="icons.mdiCalendarOutline" size="15" /> 2025–2026</div>
            </div>

            <div class="preview-stats">
              <article v-for="stat in stats" :key="stat.label" class="preview-stat">
                <span class="stat-icon" :class="stat.tone"><v-icon :icon="stat.icon" size="17" /></span>
                <span class="stat-label">{{ stat.label }}</span>
                <strong>{{ stat.value }}</strong>
                <small>{{ stat.note }}</small>
              </article>
            </div>

            <div class="preview-lower">
              <section class="enrollment-card">
                <div class="lower-heading">
                  <div><span>ACTIVITÉ</span>
                    <h3>Évolution des inscriptions</h3>
                  </div>
                  <span class="period-pill">Cette année</span>
                </div>
                <div class="chart-area" aria-hidden="true">
                  <div class="chart-guides"><i></i><i></i><i></i></div>
                  <div class="chart-bars">
                    <span v-for="(bar, index) in chartBars" :key="index" :style="{ height: `${bar}%` }"></span>
                  </div>
                  <div class="chart-months">
                    <span>Sep</span><span>Oct</span><span>Nov</span><span>Déc</span><span>Jan</span><span>Fév</span>
                  </div>
                </div>
              </section>
              <section class="recent-card">
                <div class="lower-heading">
                  <div><span>SCOLARITÉ</span>
                    <h3>Dernières inscriptions</h3>
                  </div>
                </div>
                <div v-for="student in recentStudents" :key="student.name" class="student-row">
                  <span class="student-avatar" :class="student.tone">{{ student.initials }}</span>
                  <span class="student-name">{{ student.name }}<small>{{ student.level }}</small></span>
                  <v-icon :icon="icons.mdiCheckCircleOutline" size="16" color="success" />
                </div>
              </section>
            </div>
          </div>
        </section>
        <div class="preview-caption"><span></span> Un aperçu de vos outils de gestion au quotidien</div>
      </div>
    </section>

    <section class="feature-strip" aria-label="Fonctionnalités de la plateforme">
      <div><span class="feature-icon"><v-icon :icon="icons.mdiAccountGroupOutline" /></span>
        <p><strong>Gestion des élèves</strong><small>Inscriptions et dossiers centralisés</small></p>
      </div>
      <div><span class="feature-icon"><v-icon :icon="icons.mdiBookEducationOutline" /></span>
        <p><strong>Suivi pédagogique</strong><small>Classes, enseignants et résultats</small></p>
      </div>
      <div><span class="feature-icon"><v-icon :icon="icons.mdiCashMultiple" /></span>
        <p><strong>Suivi financier</strong><small>Versements et reste à encaisser</small></p>
      </div>
    </section>
  </main>
</template>

<script>
import { router } from "@inertiajs/vue3";
import {
  mdiAccountGroupOutline,
  mdiArrowDown,
  mdiBookEducationOutline,
  mdiCalendarOutline,
  mdiCashMultiple,
  mdiCheckCircleOutline,
  mdiSchoolOutline,
  mdiAccountSchoolOutline,
  mdiHomeGroup,
} from "@mdi/js";

export default {
  data() {
    return {
      icons: {
        mdiAccountGroupOutline,
        mdiArrowDown,
        mdiBookEducationOutline,
        mdiCalendarOutline,
        mdiCashMultiple,
        mdiCheckCircleOutline,
        mdiSchoolOutline,
      },
      stats: [
        { label: "Élèves inscrits", value: "1 248", note: "Année sélectionnée", icon: mdiAccountGroupOutline, tone: "green" },
        { label: "Classes ouvertes", value: "24", note: "Toutes sections", icon: mdiHomeGroup, tone: "orange" },
        { label: "Enseignants", value: "38", note: "Équipe pédagogique", icon: mdiAccountSchoolOutline, tone: "blue" },
      ],
      chartBars: [38, 51, 44, 65, 58, 78, 69, 88, 74, 95, 82, 100],
      recentStudents: [
        { initials: "AS", name: "Aïchatou S.", level: "Terminale A", tone: "avatar-green" },
        { initials: "IM", name: "Issa M.", level: "3ème", tone: "avatar-orange" },
        { initials: "ZH", name: "Zara H.", level: "Seconde", tone: "avatar-blue" },
      ],
    };
  },
  methods: {
    goToLogin() {
      router.get(route("login"));
    },
  },
};
</script>

<style scoped>
.welcome-page {
  display: flex;
  flex-direction: column;
  height: 100%;
  min-height: 0;
  overflow: hidden;
  color: #172b29;
  background:
    radial-gradient(ellipse at 82% 17%, rgba(216, 235, 225, 0.52), transparent 32%),
    #f7faf8;
}

.welcome-hero {
  display: grid;
  flex: 1;
  grid-template-columns: minmax(300px, 0.87fr) minmax(500px, 1.13fr);
  align-items: center;
  gap: clamp(36px, 6vw, 90px);
  width: 100%;
  min-height: 0;
  margin: 0;
  padding: 0 clamp(24px, 5vw, 72px);
  box-sizing: border-box;
}

.hero-copy {
  max-width: 510px;
}

.eyebrow,
.preview-label {
  color: #176b5b;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 1.35px;
}

.eyebrow {
  display: flex;
  align-items: center;
  gap: 9px;
  margin: 0 0 22px;
}

.eyebrow span,
.preview-caption span {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #c58044;
}

.hero-copy h1 {
  max-width: 520px;
  margin: 0;
  color: #172b29;
  font-size: clamp(40px, 5vw, 64px);
  font-weight: 750;
  letter-spacing: -2.7px;
  line-height: 1.04;
}

.hero-copy h1 span {
  color: #176b5b;
}

.hero-description {
  max-width: 480px;
  margin: 22px 0 28px;
  color: #667570;
  font-size: 16px;
  line-height: 1.75;
}

.hero-actions {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 10px;
}

.primary-action {
  min-height: 48px;
  padding-inline: 21px;
  border-radius: 8px;
  font-weight: 700;
  letter-spacing: 0;
  text-transform: none;
}

.login-action {
  min-height: 48px;
  color: #176b5b;
  font-weight: 700;
  text-transform: none;
}

.hero-benefits {
  display: flex;
  flex-wrap: wrap;
  gap: 19px;
  margin-top: 24px;
  color: #667570;
  font-size: 12px;
}

.hero-benefits span {
  display: flex;
  align-items: center;
  gap: 6px;
}

.hero-benefits :deep(.v-icon) {
  color: #176b5b;
}

.preview-wrap {
  position: relative;
  min-width: 0;
  padding: 0px;
}

.preview-glow {
  position: absolute;
  inset: 7% -4% 12% 5%;
  border-radius: 28px;
  background: #c8ded3;
  filter: blur(42px);
  opacity: .52;
}

.dashboard-preview {
  position: relative;
  overflow: hidden;
  border: 1px solid #dce6e1;
  border-radius: 14px;
  background: #fff;
  box-shadow: 0 24px 65px rgba(32, 66, 54, .14);
  transform: perspective(1400px) rotateY(-3deg) rotateX(1deg);
}

.preview-topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 54px;
  padding: 0 20px;
  border-bottom: 1px solid #edf1ee;
}

.preview-brand {
  display: flex;
  align-items: center;
  gap: 9px;
  color: #27423a;
  font-size: 12px;
  font-weight: 750;
}

.brand-mark {
  display: grid;
  width: 29px;
  height: 29px;
  place-items: center;
  border-radius: 8px;
  color: #fff;
  background: #176b5b;
}

.preview-profile {
  display: grid;
  width: 28px;
  height: 28px;
  place-items: center;
  border-radius: 50%;
  background: #efe6dc;
  color: #825b37;
  font-size: 9px;
  font-weight: 800;
}

.preview-content {
  padding: 22px;
}

.preview-heading {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 17px;
}

.preview-label {
  margin: 0 0 4px;
  font-size: 8px;
  letter-spacing: 1px;
}

.preview-heading h2 {
  margin: 0;
  color: #1b332c;
  font-size: 20px;
  font-weight: 750;
}

.preview-year {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 7px 9px;
  border: 1px solid #e2e9e5;
  border-radius: 7px;
  color: #53645d;
  font-size: 10px;
}

.preview-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}

.preview-stat {
  display: grid;
  grid-template-columns: 29px 1fr;
  align-items: center;
  column-gap: 8px;
  padding: 12px 10px;
  border: 1px solid #e8eeea;
  border-radius: 9px;
}

.stat-icon {
  display: grid;
  grid-row: span 2;
  width: 29px;
  height: 29px;
  place-items: center;
  border-radius: 7px;
}

.stat-icon.green {
  color: #176b5b;
  background: #e5f1eb;
}

.stat-icon.orange {
  color: #a75f31;
  background: #f8eee5;
}

.stat-icon.blue {
  color: #426f91;
  background: #e8f0f5;
}

.stat-label {
  color: #667570;
  font-size: 9px;
  white-space: nowrap;
}

.preview-stat strong {
  margin-top: 3px;
  color: #1b332c;
  font-size: 19px;
  line-height: 1.1;
}

.preview-stat small {
  grid-column: 2;
  margin-top: 5px;
  color: #8b9892;
  font-size: 8px;
}

.preview-lower {
  display: grid;
  grid-template-columns: 1.2fr .8fr;
  gap: 10px;
  margin-top: 11px;
}

.enrollment-card,
.recent-card {
  min-width: 0;
  padding: 14px;
  border: 1px solid #e8eeea;
  border-radius: 9px;
}

.lower-heading {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
}

.lower-heading>div>span {
  color: #85918b;
  font-size: 7px;
  font-weight: 800;
  letter-spacing: .8px;
}

.lower-heading h3 {
  margin: 3px 0 0;
  color: #294239;
  font-size: 11px;
  font-weight: 700;
}

.period-pill {
  padding: 5px 7px;
  border-radius: 5px;
  background: #f1f5f2;
  color: #667570;
  font-size: 8px;
  white-space: nowrap;
}

.chart-area {
  position: relative;
  height: 117px;
  margin-top: 11px;
}

.chart-guides {
  position: absolute;
  inset: 0 0 19px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.chart-guides i {
  display: block;
  border-top: 1px dashed #e8eeea;
}

.chart-bars {
  position: absolute;
  inset: 7px 5px 19px;
  display: flex;
  align-items: end;
  justify-content: space-between;
  gap: 6px;
}

.chart-bars span {
  flex: 1;
  min-width: 5px;
  border-radius: 4px 4px 1px 1px;
  background: linear-gradient(180deg, #4d9a7c, #b7d9c8);
}

.chart-months {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  display: flex;
  justify-content: space-between;
  color: #99a49e;
  font-size: 7px;
}

.student-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 13px;
}

.student-avatar {
  display: grid;
  flex: 0 0 27px;
  width: 27px;
  height: 27px;
  place-items: center;
  border-radius: 50%;
  font-size: 8px;
  font-weight: 800;
}

.avatar-green {
  color: #176b5b;
  background: #e5f1eb;
}

.avatar-orange {
  color: #a75f31;
  background: #f8eee5;
}

.avatar-blue {
  color: #426f91;
  background: #e8f0f5;
}

.student-name {
  overflow: hidden;
  flex: 1;
  color: #354b42;
  font-size: 9px;
  font-weight: 700;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.student-name small {
  display: block;
  margin-top: 3px;
  color: #87948d;
  font-size: 8px;
  font-weight: 400;
}

.preview-caption {
  position: absolute;
  right: 0;
  bottom: 0;
  display: flex;
  align-items: center;
  gap: 7px;
  color: #64736c;
  font-size: 10px;
}

.preview-caption span {
  width: 6px;
  height: 6px;
  background: #176b5b;
}

.feature-strip {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
  width: min(1240px, calc(100% - 64px));
  margin: 0 auto;
  padding: 23px 0 30px;
  border-top: 1px solid #e5ece8;
}

.feature-strip>div {
  display: flex;
  align-items: center;
  gap: 12px;
}

.feature-icon {
  display: grid;
  flex: 0 0 40px;
  width: 40px;
  height: 40px;
  place-items: center;
  border-radius: 10px;
  color: #176b5b;
  background: #e6f1eb;
}

.feature-strip p {
  display: grid;
  gap: 3px;
  margin: 0;
}

.feature-strip strong {
  color: #30473e;
  font-size: 12px;
}

.feature-strip small {
  color: #7b8982;
  font-size: 10px;
}

@media (max-width: 960px) {
  .welcome-hero {
    grid-template-columns: minmax(260px, 0.87fr) minmax(0, 1.13fr);
    gap: 24px;
    width: calc(100% - 40px);
  }

  .hero-copy {
    max-width: 650px;
  }

  .feature-strip {
    width: calc(100% - 40px);
    padding: 14px 0;
  }
}

@media (max-width: 600px) {
  .welcome-hero {
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
    align-items: center;
    gap: 10px;
    width: calc(100% - 32px);
    padding: 0;
  }

  .hero-copy {
    width: 100%;
    max-width: none;
  }

  .preview-wrap {
    display: block;
    align-self: center;
  }

  .hero-copy h1 {
    font-size: clamp(18px, 5.5vw, 28px);
    letter-spacing: -0.8px;
    line-height: 1.08;
  }

  .eyebrow {
    gap: 5px;
    margin-bottom: 10px;
    font-size: 7px;
    letter-spacing: 0.5px;
  }

  .eyebrow span {
    flex: 0 0 6px;
    width: 6px;
    height: 6px;
  }

  .hero-description {
    margin: 10px 0 12px;
    font-size: 10px;
    line-height: 1.4;
  }

  .hero-actions {
    display: block;
  }

  .primary-action {
    width: 100%;
    max-width: 100%;
    min-height: 38px;
    padding-inline: 4px;
    font-size: 9px;
    white-space: normal;
  }

  .login-action {
    display: none;
  }

  .hero-benefits {
    display: none;
  }

  .dashboard-preview {
    transform: none;
  }

  .preview-topbar {
    height: 38px;
    padding: 0 8px;
  }

  .preview-brand {
    gap: 5px;
    font-size: 9px;
  }

  .brand-mark {
    width: 23px;
    height: 23px;
  }

  .preview-profile {
    width: 22px;
    height: 22px;
  }

  .preview-content {
    padding: 8px;
  }

  .preview-heading {
    gap: 4px;
    margin-bottom: 8px;
  }

  .preview-heading h2 {
    font-size: 13px;
  }

  .preview-year {
    display: none;
  }

  .preview-stats {
    grid-template-columns: 1fr;
    gap: 5px;
  }

  .preview-stat {
    grid-template-columns: 22px minmax(0, 1fr) auto;
    column-gap: 5px;
    padding: 5px;
  }

  .stat-icon {
    grid-row: span 2;
    width: 22px;
    height: 22px;
  }

  .stat-label {
    overflow: hidden;
    font-size: 7px;
    text-overflow: ellipsis;
  }

  .preview-stat strong {
    grid-column: 3;
    grid-row: 1 / span 2;
    font-size: 13px;
  }

  .preview-stat small,
  .preview-lower,
  .preview-caption {
    display: none;
  }

  .feature-strip {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
    width: calc(100% - 32px);
    padding: 10px 0;
  }

  .feature-strip>div {
    flex-direction: column;
    align-items: center;
    gap: 5px;
    min-width: 0;
    text-align: center;
  }

  .feature-icon {
    flex-basis: 30px;
    width: 30px;
    height: 30px;
  }

  .feature-strip small {
    display: none;
  }

  .feature-strip strong {
    font-size: 10px;
    line-height: 1.2;
  }

}

@media (max-width: 380px) {
  .feature-strip {
    gap: 4px;
    width: calc(100% - 24px);
  }

  .feature-icon {
    flex-basis: 26px;
    width: 26px;
    height: 26px;
  }

  .feature-strip strong {
    font-size: 9px;
  }
}

@media (max-width: 600px) {
  .welcome-page :deep(footer > .v-row) {
    display: none;
  }
}

@media (max-height: 700px) {
  .hero-copy h1 {
    font-size: clamp(34px, 4.2vw, 52px);
  }

  .hero-description {
    margin: 14px 0 18px;
    line-height: 1.5;
  }

  .hero-benefits {
    margin-top: 14px;
  }

  .preview-content {
    padding: 14px;
  }

  .chart-area {
    height: 88px;
  }
}

@media (max-width: 600px) and (max-height: 620px) {
  .welcome-hero {
    gap: 6px;
  }

  .hero-copy h1 {
    font-size: clamp(17px, 5vw, 24px);
  }

  .hero-description {
    margin: 7px 0 9px;
    font-size: 9px;
  }
}
</style>
