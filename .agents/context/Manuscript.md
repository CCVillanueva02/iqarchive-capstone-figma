## **IQArchive: A Document Management and Monitoring System for the Internal Quality Assurance (IQA) Office of Bicol University** 

An Undergraduate Capstone Project presented to the Information Technology Department Bicol University College of Science Legazpi City 

In Partial Fulfillment of the Requirements for the Degree of Bachelor of Science in Information Technology 

Barbacena, Janice B. Marfil, Janssen Carl M. Temajo, Vince Mathew O. Tuazon, Carl Justine O. Villanueva, Cayla C. 

# **TABLE OF CONTENTS** 

|**1 INTRODUCTION**|1|
|---|---|
|1.1 Background of the Study|1|
|1.2 Objectives of the Study|4|
|1.3 Significance of the Study|6|
|1.4 Scope and Delimitations|9|
|**2 THEORETICAL FRAMEWORK**|11|
|2.1 Review of Related Literature|11|
|2.1.1 Web-Based Solutions|11|
|2.1.2 Document Management System|12|
|2.1.3 Document Monitoring and Tracking System|13|
|2.1.4 Optical Character Recognition|14|
|2.1.5 Internal Quality Assurance in Higher Education|16|
|2.1.6 ISO 25010 Software Quality Model|18|
|2.2 Gap Bridged by the Study|20|
|2.3 Concept of the Study|21|
|2.3.1 Theoretical Framework|21|
|2.3.2 Conceptual Framework|23|
|2.4 Definition of Terms|25|
|**3 MATERIALS AND METHODS**|29|
|3.1 Materials|29|



|3.1.1 Software|29|
|---|---|
|3.1.2 Hardware|30|
|3.1.3 Software and Hardware Requirements for Client and End-Users|31|
|3.2 Software Methodology|32|
|3.2.1 Software Development Life Cycle|32|
|3.2.1.1 Why RAD over other SDLC Models|34|
|3.2.1.2 Requirements Planning|35|
|3.2.1.3 User Design|36|
|3.2.1.4 Construction|37|
|3.2.1.5 Cutover|38|
|3.3 OCR Integration Approach|39|
|3.3.1 OCR Engine|39|
|3.3.2 Image Preprocessing|40|
|3.3.3 User Review and Validation|41|
|3.4 Evaluation Procedure|41|



# **LIST OF TABLES** 

|Table 1. Software Versions|29|
|---|---|
|Table 2.<br>Hardware Requirements|30|
|Table 3. Likert Scale|31|
|Table 4. Summary of Evaluation Results|43|



# **LIST OF FIGURES** 

|Figure 1. Conceptual Framework|23|
|---|---|
|Figure 2. Rapid Application Development|33|



# **1 INTRODUCTION** 

# **1.1 Background of the Study** 

The modern IT infrastructure brought about by rapid digitalization has redefined the landscape of how organizations handle data. This transition particularly underscored a need to shift from traditional printed storage to a more efficient data management, storage, and retrieval processes. Recent reports indicate that 80% of organizations intend to replace paper-based workflows with digital systems through different digital transformation initiatives; this transition specifies a major departure from traditional manual filing (SNS Insider, 2025). This shift is primarily driven by the inefficiencies that are present in the still-adopted outdated manual techniques, as these procedures are plagued with issues, such as slow execution and haphazard arrangement, thereby causing laborious work routines (Khan & Khanam, 2023). 

On a global scale, digital transformation has become a major direction followed in public administration and institutional operations. In 2024, the United Nations Department of Economic and Social Affairs assessed e-government development across all of the 193 United Nations Member States in its report entitled “E-Government Survey 2024”. The result of the assessment specifically suggested that the global average E- Government Development Index increased by 4.59% from 2022 to 2024, whereas the previous assessment merely concluded a 1.90% increase, thereby confirming how expansion of digital government initiatives continue worldwide (United Nations Department of Economic and Social Affairs [UN DESA], 2024). The same report 

additionally emphasized the continued growth in terms of digital government by particularly listing the increased use of digital technologies in data management, integration of artificial intelligence, and the use of emerging technologies for policymaking as among the key concepts collectively referred to in this matter as global megatrends. These developments reinforce the expectedly increasing development, reliance, and maintenance of digital systems in information management.  This global movement reflects a growing consensus that digitized document management is no longer optional. 

The Philippine national government has likewise recognized the urgency of digitizing the operations in managing institutional records, as well as the procedures that administer government processes. In a recent venture, the Department of Information and Communications Technology (DICT) facilitated the accomplishment of various initiatives, such as the eGovernment Master Plan — a plan which aims to integrate technology-driven processes across public offices to enhance the overall service delivery. Similar movements have also emerged within the higher education sector, with Rodriguez et al. (2024) demonstrating this in the development of eDALAYON, which is a document management and monitoring system for the Department of the Interior and Local Government in Negros Occidental, Philippines — a system proposed in response to the challenges brought about by poor document management practices in a government office. These actions collectively represent a continued effort to help Philippine institutions depart from the manual, paper-based record systems into more efficient, digitally managed repositories. 

Bicol University is among the leading state universities in the Bicol Region. Within the university, the Office of Internal Quality Assurance (IQA) performs a central role in 

supporting institutional quality assurance activities by managing various reports, evaluations, policies, memoranda, accreditation-related records, and other supporting documents. The researchers first engaged with the IQA through an unstructured interview, which allowed the researchers to identify and explore the current practices of the office on document handling in an open manner. Specifically, this initial interview allowed the researchers to <mark>capture the office’s practices for document storage, requests, retrieval, and supervisory controls</mark> . <mark>To verify and improve the findings based on this first interview, the researchers conducted a secondary validation interview involving the IQA Office Director, two IQA members, and the clerical staff</mark> . Through these data-gathering activities, it was established that the office currently relies on a combination of printed documents stored in folders and cabinets, documents kept in a Google Drive repository, and spreadsheet-based tracking for monitoring submissions. Document requests are also commonly handled through email correspondence or face-to-face communication, with no formal tracking mechanism, approval trail, or status visibility for either the requestor or the IQA staff. A fragmented approach like this complicates document retrieval, version control, and traceability (Taufiqurrahman et al., 2025). <mark>As a consequence, staff are left with no choice but to check each record despite the substantial workload, especially during the accreditation of multiple college and university programs</mark> . In addition, certain accreditation-related documents, such as accreditation recommendations, results, and supporting records, may exist in printed or scanned form and therefore require manual scanning, uploading, or encoding before their contents can be reflected in the monitoring system (Mindoro-Mesana et al., 2023). This process adds to the workload of IQA staff and may delay the updating of submission statuses and compliance records.  Further, the 

lack of monitoring and notification capabilities exposes the office and the corresponding programs to delayed or possibly, missed submissions, especially during accreditation periods, where the issues are amplified due to the requirement submission becoming more critical — a negative impact on accreditation standings becomes possible. In this light, the identified tools currently used by the IQA, such as Google Drive and spreadsheet-based tracking, were not designed for document lifecycle management. 

In response to these identified gaps, this study proposes IQArchive: A Document Management and Monitoring System for the Internal Quality Assurance (IQA) Office of Bicol University. IQArchive aims to centralize the storage and processing of documents within the IQA office by allowing the staff and the authorized personnel to perform actions necessary in managing documents efficiently, including uploading, organizing, and retrieving documents, as well as re-structuring the existing document request process — currently handled through email or face-to-face request — into a structured request workflow that IQA staff can review, approve, or deny, with full tracking and audit trail. To transform the office’s filing system further, the system also allows the tracking of submission statuses across university programs and institutions through a monitoring component, while also notifying the stakeholders of either upcoming or missed deadlines to support accreditation compliance. Lastly, the system will help ease the burden of processing printed or scanned accreditation-related documents, such as accreditation recommendations, results, and supporting records, through an OCR-assisted upload feature that extracts printed text and assists users in encoding relevant information into the monitoring system. 

# **1.2 Objectives of the Study** 

The study aims to design and develop a Document Management and Monitoring System for Bicol University Office of Internal Quality Assurance (IQA) to facilitate easy tracking of accreditations and easy access of documents. Specifically, the study aimed to achieve the following: 

1. To design and develop a centralized digital repository that allows authorized users to upload, organize, categorize, manage, update, and retrieve documents through search and filtering features, and to submit and process document requests through a structured workflow that IQA staff can review, approve, or deny accordingly. 

2. To implement a monitoring component that enables authorized users to configure, track and monitor the document submission statuses and requirements of different university programs and institutions for accreditation compliance, receive automated notifications and reminders for upcoming and missed submission deadlines, and generate reports on document submission statuses, accreditation compliance progress, and monitoring activity across university programs and institutions. 

3. To integrate an Optical Character Recognition (OCR) feature that extracts printed text from scanned or uploaded accreditation-related documents to assist users in encoding accreditation results, submission details, and compliance-related information into the system. 

4. To determine the compliance of the developed system to ISO 25010 in terms of Functional Suitability, Performance Efficiency, Compatibility, Usability, Reliability, Security, Maintainability, and Portability. 

# **1.3 Significance of the Study** 

This study holds a significant importance because it aimed to develop a Document Management, Retrieval, and Monitoring System that will serve and help the Internal Quality Assurance (IQA) Office of Bicol University to facilitate easy tracking of accreditations and easy access of documents. Specifically, the findings of this study are advantageous to the following: 

**Internal Quality Assurance (IQA) Office.** The proposed system will directly benefit the IQA Office as it will provide a centralized digital repository for managing important documents such as policies, memorandums, and issuances. The system enables authorized personnel to upload, organize, retrieve, and track documents and required materials, as well as request documents efficiently. Furthermore, providing a system that will streamline processes will enhance document management efficiency and productivity while it decreases the need for manual file operations. Automatic updates will also increase the timely submission of required documents and their associated deadlines and will decrease the communication gaps. 

**Colleges, and Departments.** The system will enhance document management efficiency across colleges and departments by enabling authorized personnel to upload, organize, retrieve and request their files with ease. Through the document request module, colleges and departments can submit requests for specific documents they need from the IQA Office, ensuring that document access is properly tracked and managed. 

Notifying the college before an accreditation deadline, the college can take the necessary actions to ensure that the program is aligned with suggestions or recommendation requirements in a timely manner. 

**Academic Programs.** The system will prevent missed notifications of due requirements for accreditation, which keeps the program operational. 

**Finance Department.** The reaccreditation of a program requires funding before the reaccreditation deadline. By ensuring program compliance of requirements, the Finance Department can allocate the necessary budget before a visit, thus supplying the monetary needs of the program for accreditation. 

**Bicol University.** As the institution where the IQArchive will be used, Bicol University will benefit from a more efficient and organized way of managing accreditationrelated documents across colleges, departments and offices. Through modernization of the IQA’s document workflows, the university will be well equipped in responding to accreditation related requirements in a timely manner and systematic manner, strengthening its status as a top state university in the Bicol Region. 

**Community** **_._** <mark>The study will benefit the community through its development of an effective document management system which will improve university operations and service delivery. The system helps Bicol University establish transparent and accountable Internal Quality Assurance processes while it improves the management of academic and administrative documents. The university will improve its educational and service quality through this development, which will create advantages for both students and all other university stakeholders and the local community.</mark> 

**<mark>Researchers.</mark>** <mark>This study will benefit the researchers as the development of IQArchive serves as a fulfillment of a requirement for the completion of their academic course. The knowledge and experience gained from the study will further equip the researchers with relevant skills and insights that can be carried forward into their future lives in the path they will take.</mark> 

**Future Researchers** _._ This study shall serve as a reference <mark>source for future researchers who plan to study digital document management systems and centralized document storage systems. The work will deliver valuable information together with research techniques and research results, which will assist them in building better systems and performing additional research and extending their current study work in the future.</mark> 

# **1.4 Scope and Delimitations** 

This study aimed to design, develop, and evaluate a Document Management and 

Monitoring System for the Internal Quality Assurance (IQA) Office of Bicol University to facilitate easy storage, access, and tracking of documents and to enhance the office's existing processes. 

The scope of the study covers the design, development, and evaluation of IQArchive as a web-based system. Functionally, the system contains a centralized digital repository through which authorized users can upload, organize, categorize, manage, update, and retrieve documents pertaining to policy memoranda, IQA office issuances, and other accreditation-related records. The repository also includes a document request 

module through which authorized users can submit requests for specific documents, which IQA staff can review, approve, or deny accordingly. 

In addition to the centralized repository, the system includes a monitoring module through which authorized users can track and monitor the document submission statuses and compliance requirements of different university programs and institutions for accreditation purposes, receive automated notifications and reminders for upcoming and missed submission deadlines, and generate reports on submission statuses, accreditation compliance progress, and monitoring activity across university programs and institutions. 

Furthermore, the system includes an OCR-assisted upload feature that extracts printed text from scanned or uploaded accreditation-related documents to support faster encoding of accreditation results, submission details, and compliance-related information into the monitoring module. 

The primary users of IQArchive are Bicol University personnel directly involved in accreditation and quality assurance activities: IQA office staff, who manage documents, oversee compliance monitoring, and process document requests; and heads of colleges, departments, and academic programs, who submit documents, track compliance requirements relevant to their units, and receive deadline notifications. University administrators and executives may also access the system for oversight and report viewing purposes. The quality of the system will be assessed through ISO 25010 compliance, focusing on Functional Suitability, Performance Efficiency, Compatibility, 

Usability, Reliability, Security, Maintainability, and Portability, with IQA office staff and IT professionals as respondents. 

The delimitations of the study define the boundaries within which the system was developed and evaluated. IQArchive is limited to document management and monitoring in support of accreditation compliance and does not cover other institutional management functions such as payroll, human resource management, financial management, or student data management. The system is not intended to serve as a university-wide document storage platform and is restricted to the operational scope of the IQA office and its accreditation-related workflows. The administrative duties of other university offices, as well as the internal document workflows of individual colleges or departments beyond their accreditation obligations to the IQA office, are outside the scope of this study. 

In terms of technical delimitations, the OCR feature is limited to printed text extraction only — it does not recognize handwritten text and does not automatically verify, interpret, or validate the correctness of accreditation results. Extracted text may require user review and correction before being saved in the system. Finally, the study does not cover full-scale deployment or long-term maintenance of the system, as the scope is confined to the design, development, and initial evaluation phases of the system development lifecycle. 

# **2 THEORETICAL FRAMEWORK** 

In this chapter, the Review of Related Literature and Study, Concept of the Study, and the Definition of Terms were included and discussed. 

# **2.1 Review of Related Literature** 

The proposed research addresses the need for an improved document management, retrieval, and monitoring for the Internal Quality Assurance (IQA) office of Bicol University. 

## **2.1.1 Web-Based Solutions** 

With more organizations moving online, the need for purposeful systems with collaboration and sharing mechanisms have increased to manage institutional work across multiple interrelated offices. For instance, at universities, multiple departments are involved in the completion of tasks for quality assurance of documents. Web-based platforms help universities detach from cumbersome manual processes and move towards more efficient workflows. 

The use of digital document systems is reported to help institutions achieve a smooth workflow due to the organized and systematic manner by which these systems allow users to approach document management. Using centralized storage, particularly, helps organizations easily upload, access, and protect their institutional records (Hermosa, 2023). These centralized storage further reinforce the improvement of intradepartment connection, which is essential in the context of accreditation, as universities must ensure completeness and availability of necessary supporting documents to be submitted by individual institutions during accreditation periods (Galande, 2025). Further, a consolidated database makes it easier to keep track of submission, through which users 

can therefore be notified in case of missed deadlines to ensure they always meet the system's compliance requirements (Lemosnero et al., 2026). With the access to information improved by web-based systems, inter-office coordination and control of institutional work have become more possible. 

## **2.1.2 Document Management System** 

Web-based systems make it easier for office staff to collaborate. As the amount of digital records increases, efficient administration and organization become crucial. Simply keeping data is insufficient in universities where several departments create and share files. To guarantee that documents are well-organized, safe, and readily available, a system is required. These needs are met by document management systems. 

Document management systems are designed to handle the entire lifecycle of records, from creation to storage and retrieval, while maintaining security through access control and monitoring features (Han et al., 2021). This reduces the risks commonly associated with manual filing, such as document loss and duplication, while improving overall workflow efficiency. In practice, organizations that adopt DMS experience increased productivity and reduced operational costs due to automation of routine processes (Alade, 2023). 

Further improvements in document handling can be seen in systems that focus on structured categorization and indexing, allowing users to retrieve files more efficiently and accurately (Dres & Rabut, 2025). In the Philippine context, similar implementations have shown that document management systems help streamline administrative tasks and minimize document mismanagement in institutional environments (Nagrama et al., 2024; Bobby Rodriguez III et al., 2024). 

These studies show that while web-based platforms make it easier to access things, Document Management Systems make sure that information is organized and maintained in a way. However, when storage and retrieval are improved, institutions still have trouble tracking the status of documents and making sure they are submitted on time. This limitation highlights the need for document monitoring and tracking systems, which are discussed in the next section. 

## **2.1.3 Document Monitoring and Tracking System** 

Although document management systems facilitate the storage and retrieval of information, organizations still require a means of monitoring document progress and guaranteeing timely submission of requirements. This is particularly important for colleges and universities because numerous departments have deadlines to satisfy in order to be accredited. 

Hermosa et al. (2023) state that including tracking elements into document systems enables users to keep an eye on the status of documents, which facilitates the identification of delays and enhances accountability. Building on this concept, a research by Lemosnero et al. (2026) concentrated on quality assurance by creating a monitoring system to assist organizations in keeping track of adherence to necessary standards and guaranteeing timely submission of papers. Merida et al. (2026) emphasized the significance of real-time tracking and automated notifications to keep users informed of pending or missing requirements and to preserve workflow efficiency as monitoring becomes more flexible. Monitoring technologies make it easier for institutions to manage accreditation-related papers by improving visibility of submission status when processing bigger amounts of data (Mindoro-Mesana et al., 2023). 

To make sure documents are submitted on time and meet institutional standards, especially during multi-department processes like accreditation, effective monitoring is important. These systems work best when information is easy to find and well organized, so it is important to include tracking features in document management systems and other related tools. 

## **2.1.4 Optical Character Recognition** 

While web-based solutions, document management systems, and monitoring systems improve the storage, retrieval, and tracking of institutional documents, their effectiveness still depends on how quickly and accurately document information can be entered into the system. In accreditation monitoring, some results, recommendations, compliance forms, and supporting records may still come from printed or scanned documents. Uploading and encoding these materials is necessary before their details can be reflected in the monitoring records. If this is performed manually, it slows down the organizational workflow. Optical Character Recognition (OCR) can be used to assist users by extracting text from uploaded documents and will then lessen the time spent on encoding of accreditation results into the monitoring system. 

The existing systems for accreditation-related documents have shown the need for organized document handling, but OCR is not always integrated. Galande (2025) designed an Accreditation Document Management System for Apayao State College to address problems like delayed access, unavailable records, and difficulties in storing, retrieving, submitting, sharing access, and securing accreditation documents. Their work focused on digitizing and streamlining the management of accreditation documents, but their objectives and features are centered on retrieval, submission, shared access, and 

security rather than on OCR-assisted extraction from scanned accreditation results. This suggests that although accreditation document systems already support document organization and monitoring, the use of OCR for easier encoding of accreditation information is still not commonly emphasized. 

Zain et al. (2025) demonstrated the utility of OCR in archive processing by developing a system for the Borobudur Subdistrict that converts image-based documents into digital text using Tesseract OCR. It detects required text patterns using Regular Expressions, and summarizes document content using TextRank. The system increased the number of processed letters from 20 to 80 per day. Meanwhile, Pham et al. (2020) focused on improving OCR quality in a scanned document management system by applying image deskewing, table recognition, and document layout analysis before using Tesseract OCR. They found out that preprocessing improved OCR accuracy by 23% for complex documents. Singh and Middleton (2025) focused on complex tabular types of documents. They proposed a tabular context-aware OCR framework that used Table Structure Recognition, TrOCR-ctx, and ByT5 post-OCR correction to extract text from complex tabular documents. Their study showed that OCR can be more effective when it can handle tables, degraded records, and structured information. 

These studies show that OCR is useful in reducing manual encoding and converting scanned or printed documents into usable digital text. However, they also show that OCR is more commonly applied in archiving, scanned document management, or structured document extraction, rather than directly in accreditation monitoring systems. Accreditation document systems tend to focus on storage, retrieval, access control, submission, and monitoring, with little emphasis on OCR-assisted encoding. OCR 

can address a specific gap by helping users upload scanned accreditation results, recommendations, and supporting records more efficiently into the monitoring system. However, OCR accuracy may still be affected by blurred scans, skewed documents, low image quality, and complex layouts, so extracted text should still be reviewed and corrected by authorized users before being saved in the system. 

## **2.1.5 Internal Quality Assurance in Higher Education** 

Accurate, organized, and accessible records are the guiding principles that allows internal quality assurance to accomplish its objectives of effective monitoring and validation. These records also serve as building blocks, upon which reports are formulated to guide the preparation for important operations, such as accreditation. In universities, this is crucial because <mark>quality assurance offices process documents from all academic unit</mark> s; specifically, these offices maintain records, assess evidence, and track submissions for both internal auditing and assessment. Maintaining manual and fragmented processes risks documents for delayed verification and incomplete records. Further, this compromises the visibility of compliance status among institutions and programs alike. 

Using the Object-Oriented Analysis and Design Methodology (OOADM), KanayoKizito and Nwabueze (2019) proposed a Web-Based Student Record Management System for higher education. Through this methodology, the study focused on identifying system objects and defining their relationships, upon which system components were structured based on user roles and real-world entities. Through this approach the system was allowed to support multiple user roles, such as students, lecturers, parents, administrators, and organizations, each of which has been granted 

specific access and functions. Hasibuan et al. (2026), on the other hand, focused on building a web-based record management system for the Education Quality Assurance Agency to provide the said agency with an archiving system. Their study utilized the Waterfall approach, along with PHP, MySQL and Bootstrap, to provide control over the incoming and outgoing records, manage and control user accounts, oversee the uploading of records via recapitulation, and provide the ability to produce various records. The prior indicates that enhanced access and accuracy are a result of implementing such web-based applications to render management of records, while the latter study describes improvements in the retrieval, organization and efficiency of and security surrounding quality assurance related documents through such applications. 

Jannah et al. (2022) moved the discussion closer to internal quality assurance by focusing on control, compliance, and monitoring. Using a descriptive approach with observation and documentation analysis, the study explored the audit of a web-based electronic records management system for higher education institutions. Essentially, the study pointed out that electronic documents should be checked particularly for accuracy, security, compliance, and completeness instead of simply focusing on digital storage. Lemosnero et al. (2026) extended the emphasis on control practices by developing a specific quality assurance monitoring system referred to as Academic Standards Compliance and Document Management System (ASCOM), which was developed using the Waterfall model and IEEE software engineering recommendations. In addition to the emphasis on the importance of auditing and supervising electronic records, this study demonstrated how these concerns can be operationalized through a system that monitors 

academic standards compliance. Furthermore, the study recommends quality assurance systems be assessed based on both technical performance and user experience. 

# **2.2 Synthesis** 

# **2.3 Gap Bridged by the Study** 

Although numerous studies have developed web-based document systems, document monitoring tools, and Optical Character Recognition technologies, these features are commonly implemented separately. Existing document management systems usually focus on storing, organizing, retrieving, and securing institutional records, meanwhile document monitoring systems emphasize tracking submission status and deadlines. OCR-based systems, on the other hand, are often used for converting scanned or printed documents into digital text for archiving or document processing. However, these systems are not commonly integrated into a single workflow designed specifically for internal quality assurance operations and accreditation monitoring. 

This reveals an integration gap in existing systems. While document management, monitoring, and OCR each address important institutional needs, there is limited evidence of systems that combine centralized document storage, structured document request workflow, accreditation submission tracking, deadline notification, role-based access, and OCR-assisted encoding of scanned accreditation-related documents in one platform. Existing accreditation document systems tend to give limited emphasis to OCR-assisted extraction for accreditation results, recommendations, supporting records, and compliance-related information. As a result, offices that handle accreditation documents 

may still need to manually encode information from printed or scanned files before these can be reflected in monitoring records. 

There is also a technology gap in relation to the Internal Quality Assurance Office of Bicol University. The current document handling process of the office involves a combination of printed folders, Google Drive storage, and spreadsheet-based tracking, which may lead to difficulties in retrieval, version control, traceability, monitoring, and timely updating of compliance records. Additionally, document requests are currently managed through email or face-to-face communication, resulting in the absence of a formal tracking mechanism, approval trail, and status visibility for both requestors and IQA staff. These existing tools were not specifically designed to support the document lifecycle and accreditation monitoring needs of the IQA Office. 

IQArchive will bridge the identified gaps by integrating centralized document storage, search and retrieval, a structured document request workflow that replaces the current email and face-to-face request practices, submission status and accreditation monitoring, deadline reminders, role-based access control, and OCR-assisted uploading of printed or scanned accreditation-related documents. Through this integrated approach, IQArchive supports a more organized and efficient workflow for managing accreditation documents, reducing manual encoding tasks, improving visibility of submission status, and assisting the IQA Office in monitoring compliance requirements. 

# **2.3 Concept of the Study** 

## **2.3.1 Theoretical Framework** 

Several theories serve as guiding principles for the design, assessment of the system, and user adoption for IQArchive system development and assessment. 

In this study, the development framework focuses primarily on the Rapid Application Development (RAD) Model, first presented by James Martin in 1991. RAD is defined by fast, user-involved development cycles, rapid refinement, and user-prototype feedback. Technical expertise on the end user’s part is the primary concern by which the RAD model became a prudent choice for the development of IQArchive. Unlike more traditional models of development in which systematic requirements are specified prior to development, the RAD methodology empowers the researchers to develop a working prototype after each of the iterations, to which the client reacts and subsequently provides feedback. This inherently user-centered model helps diminish the distance between the needs of the user and the final product, as well as any misalignment between the final product and the office workflow. 

The DeLone and McLean Information Systems Success Model (2003) also assists in the development process and the completed system’s evaluation. To the extent of this model, system and information quality, and net benefits are crucial factors of Information Systems (IS) Success. With regards to IQArchive, this model will assist in evaluating whether the system functions as intended, information and documentation are accurate, and the system provides benefits through decreased manual workload and improved compliance to accreditation monitoring for the IQA Office and its stakeholders. 

The Technology Acceptance Model (TAM), proposed by Davis (1989), also adds to the study by stating that the perceived ease of use and perceived usefulness act as deciding factors in the process of deciding if the system will be adopted. Because the IQA Office is limitedly familiar with document management systems, it is appropriate to utilize the TAM to justify the user interface and features designed to ease the use of the IQArchive system. In this case, user-friendly navigation and document uploading, coupled with the automated and OCR-assisted digitized document management, all serve the purpose of improving usability for the users. 

Finally, the evaluation standard by which the IQArchive will undergo assessment is the ISO 25010 Quality Model, focusing on four core quality characteristics: functional stability, usability, reliability, and security. Through this assessment, the model ensures that the system satisfies a recognized international benchmark, in addition to the efficiency and functionality it provides. Overall, this model will provide a thorough, yet objective basis for measuring the system’s overall performance model upon its completion. 

## **2.3.2 Conceptual Framework** 

|Input|Process|Output|
|---|---|---|
|Documents|Document upload and storage|Controlled copy|
|Document metadata|Metadata tagging and|Controlled document|



||classification|records|
|---|---|---|
|Scanned data|OCR-assisted text extraction|Controlled data|
|Image data|Image preprocessing for OCR|Validated extracted<br>information|
|User credentials and<br>access roles|User authentication and role-<br>based access control|Authorized user access|
|Document request|Document request review,|Document request status|
|details|approval, or denial||
|Accreditation<br>submission details|Accreditation submission<br>monitoring|Submission status<br>records|
|Deadlines and|Deadline tracking and|Deadline reminders and|
|schedules|notification processing|missed-deadline alerts|
|Search and retrieval|Search, filtering, and document|Retrieved authorized|
|queries|retrieval|documents|
|User feedback and|User review and validation of|Verified accreditation-|
|validation input|OCR-extracted data|related data|



**Figure 1.** Conceptual Framework 

<mark>Figure 1 presents the Input-Process-Output (IPO) conceptual framework that illustrates the core operational mechanics and data lifecycle of IQArchive. The framework systematically maps how the system receives specific data, manipulates and manages that data through its built-in features, and generates the resulting outputs that support the</mark> 

<mark>document management and accreditation monitoring needs of the Internal Quality Assurance (IQA) Office.</mark> 

<mark>The input column identifies the raw data, user actions, and parameters that are fed into the system to initiate its functions. These inputs are categorized into documentrelated resources such as raw documents, scanned data, image data, and metadata. It also includes user-driven parameters like credentials, access roles, and search and retrieval queries, alongside monitoring variables like document request details, accreditation submission details, and deadlines. Furthermore, it accounts for human-inthe-loop interactions, specifically the user feedback and validation input required for checking extracted data. Collectively, these represent the diverse data points the system must handle to facilitate comprehensive document management.</mark> 

<mark>The process column details the system's core functional capabilities and automated operations performed on the respective inputs. This phase encompasses the system's distinct operational modules, beginning with data capture mechanisms like document upload and storage, metadata tagging, image preprocessing, and OCRassisted text extraction. It also executes security measures through user authentication and role-based access control. To manage workflow, the system handles document request reviews, monitors accreditation submissions, and processes deadline tracking and notifications. Finally, it facilitates data access and quality control through search, filtering, and document retrieval, alongside the user review and validation of OCRextracted data.</mark> 

<mark>The output column defines the transformed data, generated records, and system responses produced after processing. These outputs directly address the organizational and compliance needs of the IQA Office. Document processing yields controlled copies, structured document records, and validated extracted information, while security protocols result in authorized user access. Meanwhile, the system's monitoring and retrieval functions produce actionable outputs, including document request statuses, submission status records, deadline reminders, missed-deadline alerts, and successfully retrieved authorized documents. Ultimately, this structured flow ensures that the office has continuous access to verified accreditation-related data.</mark> 

# **2.4 Definition of Terms** 

For a better comprehension of the concept presented in this study and to further understand the key terms used, the following important terms are defined: 

**Accreditation Compliance** This is the degree to which an institution fulfills prescribed standards set by an accrediting body, demonstrating adherence to quality assurance requirements (AACCUP, 2020). In this study, it refers to the fulfillment of document submission requirements by Bicol University colleges and offices as mandated by AACCUP, monitored through the IQArchive system. 

**Authorized Users** <mark>This pertains to the individuals granted verified permission to access a system or resource based on assigned roles and credentials (Stallings, 2018).</mark> In this study, it refers to the IQA office staff, administrators, college and program heads, faculty, and university executives who are granted role-based access to use IQArchive. 

**Centralized Repository** <mark>This refers to a single, unified digital storage system that consolidates all uploaded documents from across an organization, organized and maintained for efficient access and retrieval.</mark> (ScienceDirect Topics. (n.d.). In this study, it refers to the unified digital storage within IQArchive that holds all uploaded documents, 

policies, memoranda, issuances, and accreditation records across university colleges and offices. 

**Deadline Notification** This refers to an automated alert generated by a system to inform users of approaching or elapsed due dates for required actions or submissions (Turban et al., 2018). In this study, it refers to system-generated alerts sent to authorized users reminding them of upcoming or missed document submission deadlines as defined by the IQA office. 

**Document Management System** This refers to a computer-based system designed to store, manage, track, and control the flow of electronic documents and images of paper-based information captured through document scanners (Sprague, 1995). In this study, it refers to IQArchive as the platform developed for Bicol University's IQA Office to upload, organize, retrieve, and monitor official documents related to accreditation compliance. 

**Document Monitoring** <mark>This encompasses the systematic process of tracking and supervising the submission status of required documents within an organization (ISO 15489-1, 2016). In this study, it refers to the module within IQArchive that enables the IQA Office to track the submission status of required documents per university program and monitor compliance with accreditation deadlines.</mark> 

**Document Retrieval** <mark>This is the process of searching for and accessing stored documents within a system through search and filtering features  (ScienceDirect Topics, n.d.). In this study, it refers to the ability of authorized users to locate and access stored documents within IQArchive using search keywords, category filters, and other systemprovided retrieval tools.</mark> 

**Internal Quality Assurance (IQA) Office** This is an organizational unit responsible for establishing, implementing, and monitoring quality standards across academic and administrative operations within a higher education institution (UNESCO, 2007). In this study, it refers to the Internal Quality Assurance (IQA) Office of Bicol University, which is responsible for developing and implementing a comprehensive quality assurance system to maintain, monitor, and enhance the academic standards of the University's programs. 

**ISO 25010** This refers to  a product quality model for ICT and software products, composed of nine characteristics such as functional suitability, performance efficiency, compatibility, interaction capability (formerly usability), reliability, security, maintainability, portability (now flexibility), and safety International Organization for Standardization. (ISO 25010, 2023).  In this study, it serves as the evaluation framework used to assess IQArchive in terms of functional suitability, usability, reliability, and security, with IQA staff and IT professionals as respondents. 

**Optical Character Recognition** <mark>This refers to a technology that enables converting images of typed/printed text into machine-readable format from scanned documents or photos (ScienceDirect Topics, n.d.). In this study, it refers to the feature in IQArchive that allows IQA office staff to digitize printed or scanned physical documents</mark> 

<mark>limited to printed text so that they can be uploaded, stored, and managed within the system.</mark> 

**<mark>Role-based Access Control</mark>** <mark>This refers to a security mechanism that restricts system access based on the roles assigned to individual users within an organization, ensuring users can only perform actions relevant to their responsibilities (Ferraiolo et al., 2001). In this study, it refers to the access control mechanism in IQArchive that assigns different levels of system permissions to IQA staff, administrators, college heads, and other authorized users based on their designated roles.</mark> 

# **3 MATERIALS AND METHODS** 

This chapter discusses the materials needed by the researchers together with the methodology to be used in the study. 

# **3.1 Materials** 

In this section, the proponents listed the materials used in the documentation of the study and the development of the proposed system. 

## **3.1.1 Software** 

The software requirements clearly outlined the features and functionalities of the target system, serving as a link between user expectations and the final product. As presented in Table 1, the study will utilize a variety of software development tools for both design and development. These tools included Windows 11 or above, Visual Studio Code, HTML, CSS, and JavaScript, PHP, MySQL, Laravel, and Figma. 

**Table 1.** Software Versions 

|**Software**|**Version**|
|---|---|
|Microsoft Windows OS|Windows 11 (64-bit) or Higher|
|Visual Studio Code|v1.117|
|HTML, CSS and JavaScript|Latest stable version|
|PHP|PHP 8.5.5|
|MySQL|MySQL 8.0 or Higher|
|Figma|v126.2.10|
|Laravel|v12.0|



For optimal performance, the researchers will utilize software that runs on Windows 11 (64-bit) operating system. A variety of software tools will be utilized in the development process. <mark>The user interface and user experience for the system will be ․ designed using a desktop app, Figma Source code will be edited using Visual Studio ․ Code This system code editor is a powerful‚ easy to use programming tool with support ․ for syntax highlighting‚ code completion and debugging The user interface and user ․ experience will be designed and developed using HTML‚ CSS and JavaScript PHP will be used as a back-end programming language to process the system functions and ․ MySQL as a database for storing the metadata and paths of the files In addition, Laravel was the chosen web development framework so that the development workflow is optimized, while improving the structure and efficiency of the application.</mark> 

## **3.1.2 Hardware** 

The system’s development requires the use of either a laptop or desktop computer. Laptops, due to their portability, allow access and use from various locations while still offering near-desktop level of performance. On the other hand, desktop computers prioritize power but are intended for stationary use. Proponents of the system will utilize these types of computers for all documentation and development tasks. 

**Table 2.** Hardware Requirements 

|**Hardware**|**Specifications**|
|---|---|
|Processor|Intel Core i5 or AMD Ryzen 5, 2GHz or<br>Higher|
|RAM|At least 4GB Random Access Memory or<br>Higher|
|Local Disk Space|Minimum of 128GB SSD|



The hardware requirements are essential to ensure the smooth development of the system and for the program to function properly. The system developers will utilize the preferred processor to avoid delays and inconsistencies while implementing the system and be able to deliver a platform that would satisfy the user’s needs. To run the program smoothly, the system needs a recent Windows 10 operating system, a 2 GHz or faster Intel Core i5 or AMD Ryzen 5 processor, at least 4GB of RAM, 128GB of free disk space preferably SSD, and an internet connection. 

## **3.1.3 Data** 

The data used in this study consists of two types. The first is requirements data gathered from the IQA Office of Bicol University through elicitation activities conducted during the requirements planning phase, including institutional documents, accreditation records, and workflow information obtained through interviews and document analysis. The second is evaluation data to be collected from respondents through a structured survey questionnaire administered after system demonstration, which will be used to assess the system's compliance with the ISO/IEC 25010 quality model. 

### Rapid Application Development (RAD) 



<!-- Start of picture text -->
Prototype<br>v Refine Test<br><!-- End of picture text -->

The researchers will use Rapid Application Development. As shown in Figure 2, Rapid Application Development (RAD) focuses on rapid prototyping, continuous feedback from users and iterative improvement, it enables developers to refine the system based on the user needs (Kissflow, 2026). This methodology is suitable for the development of the targeted system, since the system involves features that may require refinement based on actual office workflows, including document storage, accreditation monitoring, deadline notifications, and OCR-assisted encoding. By using RAD, the researchers will be able to accommodate changes, enhance system functionality, and prioritize user requirements, thereby supporting the timely development of a practical and high-quality system. 

## **3.2.1.1 Why RAD over other SDLC Models** 

To justify the selection of Rapid Application Development as the methodology for IQArchive, it was evaluated against three other widely recognized SDLC models — Waterfall, Agile (Scrum), and Spiral — across criteria relevant to the nature and constraints of this study. Table X presents this comparison. 

## **Table X.** _SDLC Model Comparison Matrix_ 

|**Criteria**|**Waterfall**|**Agile**<br>**(Scrum)**|**V-Model**|**Spiral**|**RAD**|
|---|---|---|---|---|---|
|Flexibility|Very Low|Very High|Low|Medium-<br>High|High|
|Documentation|Comprehensive|Minimal-<br>Moderate|Comprehensive|Extensive|Moderate|



|Customer<br>Involvement|Initial & End|Continuous|Initial & End|Each Cycle|Continuous|
|---|---|---|---|---|---|
|Testing|After Coding|Each Sprint|Each Phase<br>(Paired)|Each Cycle|Each<br>Iteration|
|Risk<br>Management|Low|Medium|Medium|Very High|Medium|
|Best Project<br>Size|Small-Medium|Any|Medium-Large|Large|Small-<br>Medium|
|Team<br>Experience<br>Needed|Low-Medium|Medium-<br>High|Medium|High|Low-<br>Medium|
|Delivery<br>Approach|Single Final|Incremental|Single Final|Spiral<br>Increments|Prototype-<br>Driven|
|Capstone<br>Suitability|High (fixed req.)|Very High|High (QA focus)|Medium<br>(complex)|**Very High**|



As shown in Table X, RAD is particularly well-suited to the development of IQArchive for several reasons. First, RAD supports high flexibility and continuous user involvement throughout the development process — both of which are essential for a system developed in direct coordination with the IQA Office, whose document handling workflows and accreditation monitoring needs ongoing clarification and refinement rather than full upfront specification. Second, RAD's prototype-driven delivery approach allowed the researchers to present working versions of the system — including the document repository structure, monitoring module, and OCR-assisted upload feature — to actual users at each iteration, enabling feedback to be incorporated before subsequent development cycles. Third, RAD's team experience requirement and project size 

suitability align with the constraints of an undergraduate capstone project, where development occurs alongside academic coursework and client access is limited to scheduled consultations, making it more practical than models that demand sustained team ceremonies or formal risk management cycles. Taken together, these characteristics make RAD the most appropriate methodology for developing a responsive, user-aligned system within the scope and timeline of this study. 

## **3.2.3.1 Requirements Planning** 

During the requirements planning phase, the researchers conducted a series of requirements elicitation activities to develop a clear and accurate understanding of the existing workflow of the Internal Quality Assurance Office. The process began with an unstructured interview facilitated by an IQA member. This initial discussion served as the researchers’ entry point into the actual operations of the office, as it introduced them to how accreditation-related documents are received, stored, requested, monitored, and retrieved. The IQA member was able to freely explain the general flow of work in the office, including the use of printed folders, Google Drive storage, spreadsheet-based tracking, and face-to-face or email-based communication. Through this activity, the researchers were able to identify the initial problems encountered by the office and form a preliminary understanding of the possible system features needed for IQArchive. 

After the initial interview, the researchers prepared survey-based instruments to verify and deepen the information they had gathered. This second elicitation activity involved the whole IQA Office, including the Director of IQA, two IQA members, and the clerical staff. The first instrument used was a preliminary validation sheet, which contained statements reflecting the researchers’ current understanding of the IQA Office. 

Through this instrument, the respondents were able to confirm which statements were accurate, identify partially accurate or inaccurate information, and provide corrections or additional details. The validation sheet covered the office’s main functions, documents handled, accreditation monitoring practices, current document storage and workflow, users and access control, and reporting practices. This allowed the researchers to correct possible assumptions from the first interview and ensure that the identified requirements were grounded on the actual practices of the IQA Office. 

Following the preliminary validation, the researchers used a guided interview form to further explore specific areas that required more detailed information. Unlike the preliminary validation sheet, which focused on confirming existing knowledge, the guided interview form was designed to gather additional details about the system requirements. It included questions on document management needs, accreditation monitoring, report generation, security and access control, OCR-related considerations, and general system expectations. The information gathered from this instrument helped the researchers clarify the required features of IQArchive, including the centralized document repository, document request workflow, monitoring module, report generation, deadline notification, role-based access control, and OCR-assisted upload feature. 

To support the information gathered from the interviews and survey-based instruments, the researchers also conducted document analysis. Existing IQA documents, forms, records, and tracking files were examined to understand the actual data handled by the office. This activity helped the researchers identify the document categories, accreditation-related information, submission status data, and monitoring records that needed to be represented in the proposed system. Through document 

analysis, the researchers were able to connect the verbal explanations of the IQA personnel with the actual documents and records used in their daily operations. 

Lastly, the researchers used prototyping to validate the proposed direction of the system with the intended users. Initial interface layouts and feature representations were presented to show how the document repository, document request workflow, monitoring dashboard, notification features, and OCR-assisted upload process would function. The feedback gathered from this activity helped the researchers refine the planned modules before proceeding to actual system development. Through these elicitation techniques, the researchers were able to establish a more complete basis for designing the system architecture, database structure, user interface, and major system modules of IQArchive. 

## **3.2.3.1.1 Use Case Diagram** 

## **3.2.3.2 User Design** 

The second phase of the RAD model is user design. In this phase, the researchers will translate the gathered requirements into visual and functional representations of the proposed system. The design process will focus on creating a user-friendly and efficient interface that would allow authorized users to upload, organize, retrieve, and monitor documents with minimal difficulty. 

The researchers will prepare system design materials such as interface layouts, navigation flow, database design, and module structures. Figma will be used in designing the user interface and user experience of IQArchive. The design emphasized simplicity, 

accessibility, and ease of navigation to ensure that IQA staff and other authorized users could operate the system effectively. The main modules considered in the design include user management, document repository, document categorization, search and retrieval, accreditation monitoring, deadline notification, and OCR-assisted encoding. 

In this phase, the researchers will also consider the feedback and expected workflow of the IQA Office. Since the system is intended to support accreditation-related document management, the design was structured to reflect how documents are submitted, reviewed, monitored, and retrieved. The user design phase allowed the researchers to refine the proposed system before actual development, ensuring that the planned features were aligned with the needs of the target users. 

# **3.3 OCR Integration Approach** 

This section describes the technical approach, the OCR engine selected, the preprocessing measures applied, and the validation procedure required before extracted text is saved into the monitoring system. 

## **3.3.1 OCR Engine** 

The system will use Tesseract OCR, an open-source optical character recognition engine maintained by Google, as the primary text extraction tool. Tesseract was selected for several reasons. First, it supports PHP integration through available wrapper libraries, making it compatible with the Laravel-based backend of IQArchive. Second, it is capable of processing standard printed document formats, including typed memos, accreditation result forms, and compliance records which are the document types that are most commonly submitted to the IQA Office in physical or scanned form. Third, as an open- 

source tool, it does not introduce licensing costs or third-party service dependencies, which is appropriate for a system intended for institutional deployment within a state university. 

Tesseract performs best on clearly printed, properly oriented documents. OCR accuracy may be reduced by low-resolution scans, skewed or rotated pages, stained or degraded paper, and complex multi-column or tabular layouts. These limitations are consistent with findings reported in the related literature, where preprocessing was shown to significantly improve OCR output for scanned institutional documents (Pham et al., 2020). 

## **3.3.2 Image Preprocessing** 

To improve the accuracy of text extraction before OCR processing is applied, the system will perform basic image preprocessing on uploaded scanned files. The preprocessing pipeline will include the following steps: conversion of uploaded images to grayscale to reduce color noise; binarization, which converts the image to black and white to sharpen character boundaries; and deskewing, which corrects minor rotational misalignment in scanned pages. These preprocessing steps are applied automatically upon file upload, prior to passing the image to the Tesseract engine. This approach is consistent with preprocessing techniques documented in the literature as effective for improving OCR output quality on scanned administrative and accreditation documents (Pham et al., 2020; Zain et al., 2025). 

## **3.3.3 User Review and Validation** 

Because OCR output is not guaranteed to be perfectly accurate, the system adopts 

an assisted encoding model rather than an automatic population model. After the OCR 

engine extracts text from an uploaded document, the extracted content is displayed to the authorized user in an editable review interface alongside the original uploaded image. The user is required to review, correct, and confirm the extracted information before it is saved into the monitoring module as an accreditation record. 

This user-in-the-loop approach serves two purposes. First, it ensures that inaccurate or incomplete OCR output does not propagate unchecked into the system's accreditation compliance records. Second, it preserves accountability, as the authorized user who reviews and confirms the data takes ownership of the saved record. The OCR feature is therefore positioned as a productivity aid — reducing the effort of encoding by providing a pre-filled draft — rather than as a fully automated data entry mechanism. This framing is consistent with how similar OCR-assisted systems in institutional contexts have been designed, where human verification remains a required step before extracted data is committed to the database (Zain et al., 2025). 

# **3.4 Evaluation Procedure** 

The developed system will be evaluated to determine its compliance with the ISO/IEC 25010 software quality model. The evaluation will focus on Functional Suitability, Performance Efficiency, Compatibility, Usability, Reliability, Security, Maintainability, and Portability, as these characteristics are directly relevant to the purpose of IQArchive as a document management and monitoring system for the Internal Quality Assurance Office of Bicol University. 

## **3.4.1 Pilot Testing 3.4.2 ISO/IEC 25010** 

**Respondents.** The evaluation will involve a target of approximately 10 to 15 respondents drawn from two groups. The first group consists of IQA office staff, including personnel directly involved in document management, accreditation monitoring, and system use. The second group consists of IT professionals who can evaluate the system's technical qualities, as well as other intended users of the system — specifically, college and department heads, program chairs, faculty members, and university administrators whose roles involve accreditation-related activities or document access within the IQA's operational scope. 

**Sampling Methodology.** Respondents will be selected through total population sampling. All available IQA office staff will be included, as the office operates with a defined and limited number of personnel directly involved in accreditation and document management. IT professionals and other intended users will be identified and included based on their institutional role and direct relevance to the system's functions. No random selection will be applied; every individual who falls within the defined respondent groups and is available for the evaluation will be included. 

**Data Collection Instrument.** The system will be evaluated using a structured survey questionnaire developed in accordance with the ISO/IEC 25010 quality criteria identified for this study. The questionnaire will be organized into sections corresponding to each quality characteristic and will use a five-point Likert scale to measure the level of agreement of each respondent regarding the quality and performance of the system, as presented in Table 4. 

**Evaluation Process.** The evaluation will be conducted by first presenting and demonstrating IQArchive to the respondents, allowing them to navigate and interact with its major features — including document uploading and retrieval, the document request workflow, the monitoring module, deadline notifications, and the OCR-assisted upload feature. After the demonstration and hands-on use, respondents will be asked to accomplish the evaluation questionnaire. The results will be tabulated and interpreted using weighted means, computed using the following formula: 



Where: 

## **WM** = weighted mean 





**N** = total number of respondents 

Where: _WM_ = weighted mean, _f_ = frequency of responses, _x_ = assigned scale value, and _N_ = total number of respondents. 

The computed mean values will be interpreted against the Likert scale in Table 4 to determine respondents' level of agreement with each evaluation criterion. The findings 

will be used to assess the overall acceptability and quality of IQArchive and to identify areas for further improvement. 

**Table 4.** Likert Scale 

|Range|Meaning|Description|
|---|---|---|
|5|Strongly Agree|The system has functional<br>completeness of tasks, is effective and<br>reliable.|
|4|Agree|The system has somehow functional<br>completeness of tasks, is somehow<br>effective and reliable.|
|3|Neutral|The system has slightly functional<br>completeness of tasks, is slightly<br>effective and reliable.|
|2|Disagree|The system has slightly no functional<br>completeness of tasks, is slightly not<br>effective and reliable.|
|||The system has no functional|
|1|Strongly Disagree|completeness of tasks, is not effective<br>and reliable.|



## **3.5 Security Architecture** 

Security is a foundational design consideration in IQArchive, given that the system 

handles confidential institutional documents, accreditation records, and personal user information. This section describes the security architecture of the system, covering rolebased access control, data encryption, confidential data classification, and data privacy compliance. 

## **3.5.1 Role-Based Access Control (RBAC)** 

IQArchive implements Role-Based Access Control (RBAC) to ensure that system functionality and data access are restricted according to each user's institutional role and responsibilities. No single user group has unrestricted access to the entire system. Upon authentication, the system assigns permissions based on the user's designated role, and all subsequent actions are governed by those role-specific boundaries. 

The system defines the following user roles and their corresponding access levels: 

**System Administrator** — has full administrative access to the system, including user account management, role assignment, system configuration, and audit log monitoring. The System Administrator does not participate in document workflows as a regular user and does not have discretionary authority to approve or deny document requests on behalf of IQA staff. 

**IQA Staff** — has access to the full document repository, including uploading, organizing, categorizing, updating, and archiving documents. IQA staff can review, approve, or deny document requests submitted by other users, manage the monitoring module, configure submission deadlines and accreditation compliance records, and use the OCR-assisted upload feature. IQA staff cannot modify user roles or system-level settings. 

## **College / Department Head and Program Chair** — has access to documents 

and monitoring records relevant to their respective college, department, or academic program. Users in this role can upload documents required by the IQA Office, submit 

document requests, view submission statuses and compliance requirements for their unit, and receive deadline notifications. They cannot access documents or monitoring records belonging to other colleges, departments, or programs. 

**Faculty Member** — has limited access to documents made available to them by IQA staff or their respective college or department head. Faculty members may submit document requests and view notifications relevant to their unit but do not have access to the monitoring module or accreditation compliance records. 

**University Administrator / Executive** — has read-only access to system-wide reports, monitoring summaries, and compliance dashboards for oversight purposes. 

Users in this role cannot upload, modify, or delete documents, nor can they approve or deny document requests. 

## **3.5.2 Access Control Types** 

Beyond role-based restrictions, IQArchive applies three layers of access control to govern how documents and data are accessed within the system. 

_Role-Based Access Control (RBAC)_ is the primary access control mechanism, as described in Section 3.5.1. It determines which modules, features, and data categories each user role can view or interact with upon login, and it is enforced at the system level regardless of individual user preferences. 

_Owner-Based Discretion_ applies to documents uploaded by a specific user or office. The uploading user or the IQA staff member responsible for a document retains 

the ability to update, reclassify, restrict, or archive that document within the permissions allowed by their role. For example, an IQA staff member who uploads a document may restrict its visibility to specific roles or units without requiring System Administrator intervention. 

_User-Based Discretion_ applies to document request submissions. Authorized users may choose which documents to request, and IQA staff retain full discretion to approve, deny, or place on hold any submitted request based on their assessment of the requestor's need and authorization. This layer ensures that document access is not solely automatic upon role assignment but remains subject to deliberate review where warranted. 

## **3.5.3 Data Encryption** 

IQArchive applies data encryption to protect confidential information both at rest and in transit. All data stored in the system database is encrypted using AES-256 (Advanced Encryption Standard with a 256-bit key), which is the minimum encryption standard adopted for this system and is consistent with internationally recognized best practices for securing sensitive institutional data. 

Data transmitted between the client and the server is secured using HTTPS with TLS (Transport Layer Security) to prevent interception or tampering during transfer. User passwords are not stored in plaintext; they are hashed using a cryptographically secure algorithm prior to storage. Session tokens are generated upon login and invalidated upon logout or session expiry to prevent unauthorized session reuse. 

## **3.5.4 Confidential Data Classification** 

The following categories of data handled by IQArchive are classified as confidential 

and are subject to the encryption, access control, and privacy compliance measures described in this section: 

- Accreditation results, findings, and recommendations pertaining to specific university programs or institutions 

- Document submission statuses and compliance records of individual colleges, departments, and academic programs 

- User account information, including names, institutional roles, email addresses, and login credentials 

- Document request records, including the identity of the requesting user, the nature of the request, and the approval or denial decision 

- OCR-extracted text derived from uploaded accreditation-related documents prior to user review and confirmation 

- Audit logs recording user actions within the system, including uploads, deletions, approvals, and access events 

Documents uploaded to the system are treated as confidential by default unless explicitly designated otherwise by an IQA staff member or System Administrator. Access to confidential documents is governed by the RBAC and access control layers described in Sections 3.5.1 and 3.5.2. 

## **3.5.5 Data Privacy Compliance** 

IQArchive is designed in compliance with Republic Act No. 10173, also known as the Data Privacy Act of 2012 of the Philippines, and its Implementing Rules and Regulations. In accordance with RA 10173, the system processes personal data only to the extent necessary for its stated institutional purpose — that is, the management of accreditation-related documents and monitoring of compliance requirements within the IQA Office of Bicol University. 

To uphold the rights of data subjects and meet the transparency requirements of RA 10173, data privacy notices are displayed on all system forms that collect personal information, including user registration forms, document request submission forms, and any form through which personal or institutional data is entered into the system. These notices inform users of the purpose for which their data is being collected, the legal basis for processing, the parties who may have access to the data, and the rights available to them under the Data Privacy Act, including the right to access, correction, and deletion of their personal data. 

The collection, storage, and processing of personal data within IQArchive is limited to what is necessary for the system's legitimate institutional functions. Data is not shared with third parties outside of Bicol University's authorized personnel, and access to personal data is restricted to users whose roles require it, as defined in Section 3.5.1. 

# **REFERENCE** 

AACCUP. (2020). _ACCREDITATION SYSTEM Standards_ . https://www.usep.edu.ph/uac/wp-content/uploads/sites/39/2019/02/AccreditationSystem.pdf 

Alade, S. M. (2023). Design and Implementation of a Web-based Document Management System. _International Journal of Information Technology and Computer Science_ , _15_ (2), 35. 

https://www.mecs-press.org/ijitcs/ijitcs-v15-n2/v15n2-4.html 

Beck, K. (2001). _Principles behind the Agile Manifesto_ . Agilemanifesto.org. https://agilemanifesto.org/principles.html 

<mark>Bobby Rodriguez III, Jun, C., Aquiatan, V. T., Agpad, S. B., Rhyan, & El. (2024). eDALAYON: A Document Management and Monitoring System for the Department of the Interior and Local Government, Philippines.</mark> _<mark>Philippine Journal of Science, Engineering, and Technology</mark>_ <mark>,</mark> _<mark>1</mark>_ <mark>(1), 34–41. https://pjset.org/index.php/journal/article/view/57</mark> 

Boehm, B. W. (1988). A spiral model of software development and enhancement. _Computer_ , _21_ (5), 61–72. https://doi.org/10.1109/2.59 

Davis, F. D. (1989). Perceived usefulness, perceived ease of use, and user acceptance of information technology. _MIS Quarterly_ , _13_ (3), 319–340. https://doi.org/10.2307/249008 

Dres, O., & Rabut, B. (2025). eDOCS: A Web-Based File Management System for Efficient File Organization. _Psychology and Education: A Multidisciplinary Journal_ , _37_ (3), 221–228. https://doi.org/10.70838/pemj.370302 

Ferraiolo, D. F., Sandhu, R., Gavrila, S., Kuhn, D. R., & Chandramouli, R. (2001). Proposed NIST standard for role-based access control. _ACM Transactions on Information and System Security_ , _4_ (3), 224–274. https://doi.org/10.1145/501978.501980 

Galande, M. H. (2025). _Accreditation Document Management System of Apayao State College, Conner Campus, Philippines_ . Journaljass.com. Retrieved June 28, 

2025, from https://journalarjass.com/index.php/ARJASS/article/view/731 

<mark>Han, J., Wang, C., Miao, J., Lu, M., Wang, Y., & Shi, J. (2021). Research on Electronic Document Management System Based on Cloud Computing.</mark> _<mark>Computers, Materials & Continua</mark>_ <mark>,</mark> _6_ _<mark>6</mark>_ <mark>(3), 2645–2654. https://doi.org/10.32604/cmc.2021.014371</mark> 

Hasibuan, N. N., Harahap, T. B., & Mhd. Furqan. (2026). _View of Design and Implementation of a Web-Based Document Archive Application at the North Sumatra Education Quality Assurance Agency_ . Lpppipublishing.com. https://lpppipublishing.com/index.php/ijessm/article/view/975/738 

Hermosa, K. R., Loteriña, V. C. B., & Sebuc, J. A. (2023). DOCUMENT MANAGEMENT SYSTEM WITH TRACKING AND MONITORING IN MANUEL S. 

ENVERGA UNIVERSITY FOUNDATION-CANDELARIA INC. _International Journal of Advanced Research in Computer Science_ , _14_ (6), 31–43. https://doi.org/10.26483/ijarcs.v14i6.7038 

Irfan Syamsuddin, & Arda Yunianta. (2022). Design and usability assessment of DocManS: A document management system with security and social media features. _International Journal of Advanced and Applied Sciences_ , _9_ (1), 48–54. https://doi.org/10.21833/ijaas.2022.01.007 

<mark>ISO - International Organization for Standardization. (2016, April 26).</mark> _<mark>ISO 154891:2016</mark>_ <mark>. ISO. https://www.iso.org/standard/62542.html</mark> 

<mark>ISO 25010. (2023).</mark> _<mark>ISO/IEC FDIS 25010</mark>_ <mark>. ISO. https://www.iso.org/standard/78176.html</mark> 

<mark>Kanayo Kizito Uka, & Nwabueze, E. (2019, June).</mark> _<mark>Web Based Students’ Record Management System for Tertiary Institutions</mark>_ <mark>. ResearchGate; unknown. https://www.researchgate.net/profile/Kanayo-Uka/publication/340952903_Web_B ased_Students</mark> 

Khan, S., & Khanam, A. T. (2023). Design and Implementation of a Document Management System with MVC Framework. _International Journal of Scientific Research in Computer Science, Engineering and Information Technology_ , _9_ (4), 420–424. https://doi.org/10.32628/cseit2390451 

Kissflow, T. (2026, March 19). _Rapid Application Development (RAD) | Definition, Steps & Full Guide_ . Kissflow. https://kissflow.com/application-development/rad/rapid-application-development/ Kommey, B., Gyimah, F., Kponyo, J. J., & Andam-Akorful, S. A. (2022). A Web Based System for Easy and Secured Managing Process of University Accreditation Information. _Indonesian Journal of Computing, Engineering and Design (IJoCED)_ , _4_ (1), 17. https://doi.org/10.35806/ijoced.v4i1.240 

Lemosnero, K. R., Duhilag, D. M., Lumingkit, R., Nuevo, L., & Flores, S. G. (2026). Quality Assurance Office Monitoring System: Academic Standards Compliance and Document Management System. _International Journal of Science and Applied_ 

_Information Technology_ , _15_ (1), 23–28. 

https://doi.org/10.30534/ijsait/2026/041512026 

Merida , M., Gemina, M. N., Bahay, D. J., Nuevo, L., Encarnacion, P., & Demandaco, N. (2026). Hybrid Web-Based Letter and Document Management System for Saint Columban College. _International Journal of Advanced Trends in Computer Science and Engineering_ , _15_ (1), 1–6. https://doi.org/10.30534/ijatcse/2026/011512026 

Mindoro-Mesana, J. M., Mesana, J. P., & Mariño, L. (2023). Design and Development of Romblon State University Romblon Campus Accreditation Data Warehouse. _Romblon State University Research Journal_ , _4_ (2), 17–24. https://doi.org/10.58780/rsurj.v4i2.54 

Nagrama, N. D., Lingating, M. L., Calleno, J., Rato, R. K., Catungal, M. L., & Encarnacion, P. (2024). Web-based Document Management System. _International Journal of Science and Applied Information Technology_ , _13_ (3), 16– 21. https://doi.org/10.30534/ijsait/2024/031332024 

Pargaonkar, S. (2023). A Comprehensive Research Analysis of Software Development Life Cycle (SDLC) Agile & Waterfall Model Advantages, Disadvantages, and Application Suitability in Software Quality Engineering. _International Journal of Scientific and Research Publications_ , _13_ (8), 120–124. https://doi.org/10.29322/ijsrp.13.08.2023.p14015 

Pham, V. A., Nguyen, D. T. K., Tran, M. D., & Pham, V. D. (2022). IMPROVED OCR QUALITY FOR SMART SCANNED DOCUMENT MANAGEMENT SYSTEM. _Journal of Science and Technique_ , _9_ (1). https://doi.org/10.56651/lqdtu.jst.v9.n01.60.ict 

<mark>Richatul Jannah, Fitrarena Widhi Rizkyana, & Risanda Alirastra Budiantoro. (2022). Audit of A Web-Based Electronic Documents and Record Management System (WEDRMS): Oversight Efforts to Improve Administration in Higher Educational Institutions.</mark> _<mark>BISECER (Business Economic Entrepreneurship)</mark>_ , _<mark>5</mark>_ <mark>(2), 53–60. https://ejournal.undaris.ac.id/index.php/biceser/article/view/427/311</mark> 

Royce, W. (1970b). _MANAGING THE DEVELOPMENT OF LARGE SOFTWARE SYSTEMS_ (pp. 1–9). https://www.praxisframework.org/files/royce1970.pdf 

ScienceDirect Topics. (n.d.-a). Product and plant knowledge management. _Practical E-Manufacturing and Supply Chain Management_ , 185–213. https://doi.org/10.1016/b978-075066272-7/50010-5 

ScienceDirect Topics. (n.d.). _Centralized Repository - an overview | ScienceDirect Topics_ . Www.sciencedirect.com. https://www.sciencedirect.com/topics/computerscience/centralized-repository 

ScienceDirect Topics. (n.d.). Offline recognition of handwritten Indic scripts: A state-of-the-art survey and future perspectives. _Computer Science Review_ , _38_ , 100302. https://doi.org/10.1016/j.cosrev.2020.100302 

Singh, L. G., & Middleton, S. E. (2025). Tabular context-aware optical character recognition and tabular data reconstruction for historical records. _International_ 

_Journal on Document Analysis and Recognition (IJDAR)_ . https://doi.org/10.1007/s10032-025-00543-9 

SNS Insider. (2025, October 23). _Document Management System Market Size,_ 

_Share & Growth Report 2033_ . SNS Insider. 

https://www.snsinsider.com/reports/document-management-systemmarket-8795? 

fbclid=IwY2xjawRi3fdleHRuA2FlbQIxMABicmlkETEzajJ1R0VLSHJzSThmQjZac3 J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHpJ3DdZplHoU2mw- 

zg3V77JUBMSbV3rUsn2_hXsVNUptcHMbIBNsUjWHoddE_aem_ZHPbyWnPpJRL52ibkuZfg 

Sprague, R. H. (1995). Electronic Document Management: Challenges and Opportunities for Information Systems Managers. _MIS Quarterly_ , _19_ (1), 29. https://doi.org/10.2307/249710 

Stallings, W. (2018). _Effective Cybersecurity_ . https://ptgmedia.pearsoncmg.com/images/9780134772806/samplepages/978013 4772806_Sample.pdf 

<mark>Taufiqurrahman, Junaedy, & Rizal, S. (2025).</mark> _<mark>Welcome To Zscaler Directory Authentication</mark>_ <mark>. Unusia.ac.id. https://journal.unusia.ac.id/nuai/article/view/1663</mark> 

Turban , D. C., Liang, T.-P., Turban, E., & Lee, J. K. (2009, October 22). _Electronic Commerce: A Managerial Perspective_ . ResearchGate; Prentice Hall. https://www.researchgate.net/publication/282733143_Electronic_Commerce_A_ Managerial_Perspective 

UNESCO. (2007). _External quality assurance in higher education: making choices_ 

_| IIEP-UNESCO_ .Www.iiep.unesco.org. 

https://www.iiep.unesco.org/en/publication/external-quality-assurance-higher- 

education-making-choices 

UNESCO. (2019, November 25). _External quality assurance in higher education: making choices | IIEP-UNESCO_ . Www.iiep.unesco.org. https://www.iiep.unesco.org/en/publication/external-quality-assurance-highereducation-making-choices 

United Nations. (2024, June 28). _The Sustainable Development Goals Report 2024_ . DESA Publications. 

https://desapublications.un.org/publications/sustainable-development-goalsreport-2024 

Zain, A., Setiawan, A., & Sasongko, D. (2025). OCR implementation in archiving system at Borobudur Subdistrict using regular expression and TextRank methods. _BIS Information Technology and Computer Science_ , _2_ , V225002. https://doi.org/10.31603/bistycs.179 

