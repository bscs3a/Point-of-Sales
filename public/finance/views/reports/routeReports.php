<script>
    const fs = require('fs');
    const puppeteer = require('puppeteer');

    async function printPDF(url) {
        const browser = await puppeteer.launch({ headless: true });
        const page = await browser.newPage();
        await page.goto(url, {waitUntil: 'networkidle0'});
        const pdf = await page.pdf({ format: 'A4' });

        await browser.close();
        return pdf;
    }
    
    // Replace this with the actual URL
    const url = 'http://localhost/Finance/public/finance/views/reports/incomeReport.php';

    printPDF(url).then(pdf => {
        fs.writeFile('report.pdf', pdf, () => {
            console.log('PDF saved as report.pdf');
        });
    });
</script>