$(document).ready(function(){

var depart = "-Select your department-";


///////////////////////////////////////////////////////////////////////////////////
/* DEPARTMENTS */
var phySci = [
	{display: depart, value: "" },
	{display: "computer science", value: "computerScience" },
	{display: "statistics", value: "statistics" },
	{display: "physics and astronomy", value: "physicsAndAstronomy" },
	{display: "geology", value: "geology" },
	{display: "mathematics", value: "mathematics" },
	{display: "pure and industrial chemnistry", value: "pureAndIndustrialChemistry" }
];

var bioSci = [
	{display: depart, value: "" },
	{display: "micro biology", value: "microBiology" },
	{display: "biochemistry", value: "bioChemistry" },
	{display: "plant science", value: "plantScience" },
	{display: "zoology", value: "zoology" }
];

var agricSci = [
	{display: depart, value: "" },
	{display: "soil science", value: "soilScience" },
	{display: "agric economics", value: "agricEconomics" },
	{display: "agric extension", value: "agricExtension" },
	{display: "animal science", value: "animalScience" }
];

var arts = [
	{display: depart, value: "" },
	{display: "mass communication", value: "massCommunication" },
	{display: "archaeology and tourism", value: "archaeologyAndTourism" },
	{display: "history and international studies", value: "historyAndInternationalStudies" },
	{display: "fine and applied arts", value: "fineAndAppliedArts" },
	{display: "performing arts", value: "performingArts" },
	{display: "music", value: "music" },
	{display: "english and literary studies", value: "englishAndLiteraryStudies" },
	{display: "foreign languages", value: "foreignLanguages" },
	{display: "linguistics and nigerian language", value: "linguisticsAndNigerianLanguage" }
];

var busAdmin = [
	{display: depart, value: "" },
	{display: "accountancy", value: "accountancy" },
	{display: "marketing", value: "marketing" },
	{display: "business administration", value: "businessAdministration" },
	{display: "banking and finance", value: "bankingAndFinance" },
	{display: "management", value: "management" }
];

var education = [
	{display: depart, value: "" },
	{display: "arts education", value: "artsEducation" },
	{display: "science education", value: "scienceEducation" },
	{display: "adult education", value: "adultEducation" },
	{display: "education foundation", value: "educationFoundation" },
	{display: "health and physical education", value: "healthAndPhysicalEducation" },
	{display: "library science education", value: "libraryScienceEducation" },
	{display: "social science education", value: "socialScienceEducation" },
	{display: "computer education", value: "computerEducation" },
	{display: "home economics", value: "homeEconomics" },
	{display: "vocational teacher education", value: "vocationalTeacherEducation" }
];

var engine = [
	{display: depart, value: "" },
	{display: "civil engineering", value: "civilEngineering" },
	{display: "electronic engineering", value: "electronicEngineering" },
	{display: "electrical engineering", value: "electricalEngineering" },
	{display: "mechanical engineering", value: "mechanicalEngineering" },
	{display: "agric and bioresources engineering", value: "agricAndBioResourcesEngineeing" },
	{display: "metals and metallurgical engineering", value: "metalsAndMetallurgicalEngineering" }
];

var dentistry = [
	{display: depart, value: "" },
	{display: "child dental health", value: "childDentalHealth" },
	{display: "oral maxillofacial surgery", value: "oralMaxillofacialSurgery" },
	{display: "preventive dentistry", value: "preventiveDentistry" },
	{display: "restorative dentistry", value: "restorativeDentistry" }
];

var envStud = [
	{display: depart, value: "" },
	{display: "estate management", value: "estateManagement" },
	{display: "urban and regional planning", value: "urbanAndRegionalPlanning" },
	{display: "architecture", value: "architecture" },
	{display: "surverying and geodesy", value: "surveyingAndGeodesy" }
];

var healthSciTech = [
	{display: depart, value: "" },
	{display: "medical rehabilitation", value: "medicalRehabilitation" },
	{display: "nursing sciences", value: "nursingSciences" },
	{display: "medical laboratory technology", value: "medicalLaboratoryTechnology" }
];

var law = [
	{display: depart, value: "" },
	{display: "public and private law", value: "publicAndPrivateLaw" },
	{display: "international law and jurisprudence", value: "internationalLawAndJurisprudence" },
	{display: "property law", value: "propertyLaw" }
];

var pharmSci = [
	{display: depart, value: "" },
	{display: "clinical pharmacy", value: "clinicalPharmacy" },
	{display: "pharmaceutical and medical chemistry", value: "pharmaceuticalAndMedicalChemistry" },
	{display: "pharmacology and toxicology", value: "pharmacologyAndToxicology" },
	{display: "pharmaceutics", value: "pharmaceutics" },
	{display: "pharmaceutical technology", value: "pharmaceuticalTechnology" },
	{display: "pharmacognosy", value: "pharmacognosy" },
	{display: "pharmacognosy and environmental medicines", value: "pharmacognosyAndEnvironmentalMedicines" }
];

var socialSci = [
	{display: depart, value: "" },
	{display: "philosophy", value: "philosophy" },
	{display: "public administration", value: "publicAdministration" },
	{display: "psychology", value: "psychology" },
	{display: "economics", value: "economics" },
	{display: "geography", value: "geography" },
	{display: "sociology and anthropology", value: "sociologyAndAnthropology" },
	{display: "religious and cultural studies", value: "religiousAndCulturalStudies" },
	{display: "social work", value: "socialWork" }
];

var medSci = [
	{display: depart, value: "" },
	{display: "anaesthesia", value: "anaesthesia" },
	{display: "anatomy", value: "anatomy" },
	{display: "chemical pathology", value: "chemicalPathology" },
	{display: "community medicine", value: "communityMedicine" },
	{display: "dermatology", value: "dermatology" },
	{display: "haematology and immunology", value: "haematologyAndImmunology" },
	{display: "medical biochemistry", value: "medicalBiochemistry" },
	{display: "medical microbiology", value: "medicalMicrobiology" },
	{display: "morbid anatomy", value: "morbidAnatomy" },
	{display: "obstetrics and gaenecology", value: "obstetricsAndGaenecology" },
	{display: "ophthalmology", value: "ophthalmology" },
	{display: "otolaringology", value: "otolaringology" },
	{display: "paediatrics", value: "paediatrics" },
	{display: "paediatric surgery", value: "paediatricSurgery" },
	{display: "pharmacology and therapeutics", value: "pharmacologyAndTherapeutics" },
	{display: "physiological medicine", value: "physiologicalMedicine" },
	{display: "radiation medicine", value: "radiationMedicine" },
	{display: "surgery", value: "surgery" }
];

var vetMed = [
	{display: depart, value: "" },
	{display: "veterinary pathology and microbiology", value: "veterinaryPathologyAndMicrobiology" },
	{display: "veterinary obstetrics and reproductive diseases", value: "veterinaryObstetricsAndReproductiveDiseases" },
	{display: "veterinary physiology and pharmacology", value: "veterinaryPhysiologyAndPharmacology" },
	{display: "veterinary anatomy", value: "veterinaryAnatomy" },
	{display: "veterinary medicine", value: "veterinaryMedicine" },
	{display: "veterinary surgery", value: "veterinarySurgery" },
	{display: "veterinary parasitology and entomology", value: "veterinaryParasitologyAndEntomology" },
	{display: "animal health and production", value: "animalHealthAndProduction" },
	{display: "veterinary public health and preventive medicine", value: "veterinaryPublicHealthAndPreventiveMedicine" },
	{display: "veterinary teaching hospital", value: "veterinaryTeachingHospital" },
];


///////////////////////////////////////////////////////////////////////////////////

/* PHYSICAL SCIENCES */
var computerScience = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var statistics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var physicsAndAstronomy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var geology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var mathematics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
];
var pureAndIndustrialChemistry = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* BIOLOGICAL SCIENCES */
var microBiology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
];
var bioChemistry = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var plantScience = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var zoology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* AGRICULTURAL SCIENCE */
var soilScience = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var agricEconomics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var agricExtension = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var animalScience = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];

/* ARTS */
var massCommunication = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var archaeologyAndTourism = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var historyAndInternationalStudies = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var fineAndAppliedArts = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var performingArts = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var music = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var englishAndLiteraryStudies = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var foreignLanguages = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var linguisticsAndNigerianLanguage = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* BUSINESS ADMINISTRATION */
var accountancy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var marketing = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var businessAdministration = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var bankingAndFinance = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
];
var management = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* EDUCATION */
var artsEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
];
var scienceEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var adultEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var educationFoundation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var healthAndPhysicalEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var libraryScienceEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var socialScienceEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var computerEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
];
var homeEconomics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var vocationalTeacherEducation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* ENGINEERING */
var civilEngineering = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var electronicEngineering = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var electricalEngineering = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var mechanicalEngineering = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var agricAndBioResourcesEngineeing = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var metalsAndMetallurgicalEngineering = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];

/* DENTISTRY */
var childDentalHealth = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var oralMaxillofacialSurgery = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var preventiveDentistry = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var restorativeDentistry = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];

/* ENVIRONMENTAL STUDIES */
var estateManagement = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var urbanAndRegionalPlanning = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var architecture = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var homeEconomics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var surveyingAndGeodesy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];

/* HEALTH SCIENCE AND TECHNOLOGY */
var medicalRehabilitation = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var nursingSciences = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var medicalLaboratoryTechnology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* LAW */
var publicAndPrivateLaw = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var internationalLawAndJurisprudence = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var propertyLaw = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];

/* PHARMACEUTICAL SCIENCE */
var clinicalPharmacy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var pharmaceuticalAndMedicalChemistry = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var pharmacologyAndToxicology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var pharmaceutics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var pharmaceuticalTechnology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var pharmacognosy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];
var pharmacognosyAndEnvironmentalMedicines = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500}
];

/* SOCIAL SCIENCES */
var philosophy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var publicAdministration = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var psychology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var economics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var geography = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var sociologyAndAnthropology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var religiousAndCulturalStudies = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];
var socialWork = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400}
];

/* MEDICAL SCIENCE */
var anaesthesia = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var anatomy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var chemicalPathology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var communityMedicine = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var dermatology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var haematologyAndImmunology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var medicalBiochemistry = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var medicalMicrobiology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var morbidAnatomy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var obstetricsAndGaenecology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var ophthalmology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var otolaringology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var paediatrics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var paediatricSurgery = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var pharmacologyAndTherapeutics = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var physiologicalMedicine = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var radiationMedicine = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var surgery = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];

/* VETERINARY MEDICINE */
var veterinaryPathologyAndMicrobiology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryObstetricsAndReproductiveDiseases = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryPhysiologyAndPharmacology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryAnatomy = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryMedicine = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinarySurgery = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryParasitologyAndEntomology = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var animalHealthAndProduction = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryPublicHealthAndPreventiveMedicine = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];
var veterinaryTeachingHospital = [
	{display:100, value: 100},
	{display:200, value: 200},
	{display:300, value: 300},
	{display:400, value: 400},
	{display:500, value: 500},
	{display:600, value: 600}
];


///////////////////////////////////////////////////////////////////////////////////
//If faculty option is changed
$("#faculty").change(function() {
	var parent = $(this).val(); //get option value from faculty
	
	switch(parent){ //using switch compare selected option and populate department
		case 'physical-science':
			faculty(phySci);
			break;
		case 'biological-science':
			faculty(bioSci);
			break;             
		case 'agricultural-science':
			faculty(agricSci);
			break;
		case 'arts':
			faculty(arts);
			break;
		case 'business-administration':
			faculty(busAdmin);
			break;
		case 'education':
			faculty(education);
			break;
		case 'engineering':
			faculty(engine);
			break;
		case 'dentistry':
			faculty(dentistry);
			break;
		case 'environmental-studies':
			faculty(envStud);
			break;
		case 'health-science-and-technology':
			faculty(healthSciTech);
			break;
		case 'law':
			faculty(law);
			break;
		case 'pharmaceutical-science':
			faculty(pharmSci);
			break;
		case 'social-science':
			faculty(socialSci);
			break;
		case 'medical-science':
			faculty(medSci);
			break;
		case 'veterinary-medicine':
			faculty(vetMed);
			break;
		default: //default department option is blank
			$("#department").html('');  
			break;
	   }
});
//function to populate department select box
function faculty(array_list)
{
    $("#department").html(""); //reset department options
    $(array_list).each(function (i) { //populate department options
        $("#department").append("<option value="+array_list[i].value+">"+array_list[i].display+"</option>");		
    });
	
}

///////////////////////////////////////////////////////////////////////////////////
$("#department").change(function() {	
	// find-out the department so you can give the appropriate levels
	var depLvl = $(this).val();
	switch(depLvl){
		/* PHYSICAL SCIENCES */
		case 'computerScience':
			level(computerScience);
			break;
		case 'statistics':
			level(statistics);
			break;
		case 'physicsAndAstronomy':
			level(physicsAndAstronomy);
			break;
		case 'geology':
			level(geology);
			break;
		case 'mathematics':
			level(mathematics);
			break;
		case 'pureAndIndustrialChemistry':
			level(pureAndIndustrialChemistry);
			break;
			
		case 'microBiology':
			level(microBiology);
			break;
		case 'bioChemistry':
			level(bioChemistry);
			break;
		case 'plantScience':
			level(plantScience);
			break;
		case 'zoology':
			level(zoology);
			break;
			
		case 'soilScience':
			level(soilScience);
			break;
		case 'agricEconomics':
			level(agricEconomics);
			break;
		case 'agricExtension':
			level(agricExtension);
			break;
		case 'animalScience':
			level(animalScience);
			break;
			
		case 'massCommunication':
			level(massCommunication);
			break;
		case 'archaeologyAndTourism':
			level(archaeologyAndTourism);
			break;
		case 'historyAndInternationalStudies':
			level(historyAndInternationalStudies);
			break;
		case 'fineAndAppliedArts':
			level(fineAndAppliedArts);
			break;
		case 'performingArts':
			level(performingArts);
			break;
		case 'music':
			level(music);
			break;
		case 'englishAndLiteraryStudies':
			level(englishAndLiteraryStudies);
			break;
		case 'foreignLanguages':
			level(foreignLanguages);
			break;
		case 'linguisticsAndNigerianLanguage':
			level(linguisticsAndNigerianLanguage);
			break;
			
		case 'accountancy':
			level(accountancy);
			break;
		case 'marketing':
			level(marketing);
			break;
		case 'businessAdministration':
			level(businessAdministration);
			break;
		case 'bankingAndFinance':
			level(bankingAndFinance);
			break;
		case 'management':
			level(management);
			break;
			
		case 'artsEducation':
			level(artsEducation);
			break;
		case 'scienceEducation':
			level(scienceEducation);
			break;
		case 'adultEducation':
			level(adultEducation);
			break;
		case 'educationFoundation':
			level(educationFoundation);
			break;
		case 'healthAndPhysicalEducation':
			level(healthAndPhysicalEducation);
			break;
		case 'libraryScienceEducation':
			level(libraryScienceEducation);
			break;
		case 'socialScienceEducation':
			level(socialScienceEducation);
			break;
		case 'computerEducation':
			level(computerEducation);
			break;
		case 'homeEconomics':
			level(homeEconomics);
			break;
		case 'vocationalTeacherEducation':
			level(vocationalTeacherEducation);
			break;
			
		case 'civilEngineering':
			level(civilEngineering);
			break;
		case 'electronicEngineering':
			level(electronicEngineering);
			break;
		case 'electricalEngineering':
			level(electricalEngineering);
			break;
		case 'mechanicalEngineering':
			level(mechanicalEngineering);
			break;
		case 'agricAndBioResourcesEngineeing':
			level(agricAndBioResourcesEngineeing);
			break;
		case 'metalsAndMetallurgicalEngineering':
			level(metalsAndMetallurgicalEngineering);
			break;
			
		case 'childDentalHealth':
			level(childDentalHealth);
			break;
		case 'oralMaxillofacialSurgery':
			level(oralMaxillofacialSurgery);
			break;
		case 'preventiveDentistry':
			level(preventiveDentistry);
			break;
		case 'restorativeDentistry':
			level(restorativeDentistry);
			break;
			
		case 'estateManagement':
			level(estateManagement);
			break;
		case 'urbanAndRegionalPlanning':
			level(urbanAndRegionalPlanning);
			break;
		case 'architecture':
			level(architecture);
			break;
		case 'homeEconomics':
			level(homeEconomics);
			break;
		case 'surveyingAndGeodesy':
			level(surveyingAndGeodesy);
			break;
			
		case 'medicalRehabilitation':
			level(medicalRehabilitation);
			break;
		case 'nursingSciences':
			level(nursingSciences);
			break;
		case 'medicalLaboratoryTechnology':
			level(medicalLaboratoryTechnology);
			break;
			
		case 'publicAndPrivateLaw':
			level(publicAndPrivateLaw);
			break;
		case 'internationalLawAndJurisprudence':
			level(internationalLawAndJurisprudence);
			break;
		case 'propertyLaw':
			level(propertyLaw);
			break;
			
		case 'clinicalPharmacy':
			level(clinicalPharmacy);
			break;
		case 'pharmaceuticalAndMedicalChemistry':
			level(pharmaceuticalAndMedicalChemistry);
			break;
		case 'pharmacologyAndToxicology':
			level(pharmacologyAndToxicology);
			break;
		case 'pharmaceutics':
			level(pharmaceutics);
			break;
		case 'pharmaceuticalTechnology':
			level(pharmaceuticalTechnology);
			break;
		case 'pharmacognosy':
			level(pharmacognosy);
			break;
		case 'pharmacognosyAndEnvironmentalMedicines':
			level(pharmacognosyAndEnvironmentalMedicines);
			break;
			
		case 'philosophy':
			level(philosophy);
			break;
		case 'publicAdministration':
			level(publicAdministration);
			break;
		case 'psychology':
			level(psychology);
			break;
		case 'economics':
			level(economics);
			break;
		case 'geography':
			level(geography);
			break;
		case 'sociologyAndAnthropology':
			level(sociologyAndAnthropology);
			break;
		case 'religiousAndCulturalStudies':
			level(religiousAndCulturalStudies);
			break;
		case 'socialWork':
			level(socialWork);
			break;
			
		case 'anaesthesia':
			level(anaesthesia);
			break;
		case 'anatomy':
			level(anatomy);
			break;
		case 'chemicalPathology':
			level(chemicalPathology);
			break;
		case 'communityMedicine':
			level(communityMedicine);
			break;
		case 'dermatology':
			level(dermatology);
			break;
		case 'haematologyAndImmunology':
			level(haematologyAndImmunology);
			break;
		case 'medicalBiochemistry':
			level(medicalBiochemistry);
			break;
		case 'medicalMicrobiology':
			level(medicalMicrobiology);
			break;
		case 'morbidAnatomy':
			level(morbidAnatomy);
			break;
		case 'obstetricsAndGaenecology':
			level(obstetricsAndGaenecology);
			break;
		case 'ophthalmology':
			level(ophthalmology);
			break;
		case 'otolaringology':
			level(otolaringology);
			break;
		case 'paediatrics':
			level(paediatrics);
			break;
		case 'paediatricSurgery':
			level(paediatricSurgery);
			break;
		case 'pharmacologyAndTherapeutics':
			level(pharmacologyAndTherapeutics);
			break;
		case 'physiologicalMedicine':
			level(physiologicalMedicine);
			break;
		case 'radiationMedicine':
			level(radiationMedicine);
			break;
		case 'surgery':
			level(surgery);
			break;
			
		case 'veterinaryPathologyAndMicrobiology':
			level(veterinaryPathologyAndMicrobiology);
			break;
		case 'veterinaryObstetricsAndReproductiveDiseases':
			level(veterinaryObstetricsAndReproductiveDiseases);
			break;
		case 'veterinaryPhysiologyAndPharmacology':
			level(veterinaryPhysiologyAndPharmacology);
			break;
		case 'veterinaryAnatomy':
			level(veterinaryAnatomy);
			break;
		case 'veterinaryMedicine':
			level(veterinaryMedicine);
			break;
		case 'veterinarySurgery':
			level(veterinarySurgery);
			break;
		case 'veterinaryParasitologyAndEntomology':
			level(veterinaryParasitologyAndEntomology);
			break;
		case 'animalHealthAndProduction':
			level(animalHealthAndProduction);
			break;
		case 'veterinaryPublicHealthAndPreventiveMedicine':
			level(veterinaryPublicHealthAndPreventiveMedicine);
			break;
		case 'veterinaryTeachingHospital':
			level(veterinaryTeachingHospital);
			break;
			
		default:
		$("#level").html('');
		break;
	};
});

//function to populate levels select box
function level(array_list)
{
    $("#level").html("");
    $(array_list).each(function (i) {
        $("#level").append("<option value="+array_list[i].value+">"+array_list[i].display+"</option>");		
    });
	
}
	
});