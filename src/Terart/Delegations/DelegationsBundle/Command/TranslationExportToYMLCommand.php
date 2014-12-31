<?php

namespace Terart\Delegations\DelegationsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Writer\TranslationWriter;

class TranslationExportToYMLCommand extends ContainerAwareCommand {
    /**
     * @var Finder
     */
    protected $finder;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    protected function configure(){
        parent::configure();
        $this
            ->setName('delegation:translation:save')
            ->setDescription('')
            ->setHelp('')
            ->addOption('locale', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('value', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('locale', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('filename', null, InputOption::VALUE_REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locale = $input->getOption('locale');
        $filename = $input->getOption('filename');
        $id = $input->getOption('id');
        $value = $input->getOption('value');
        $outputFormat = $inputFormat = 'yml';
        if (!$this->getTranslationPath() || !$this->getFilesystem()->exists($this->getTranslationPath())) {
            throw new \InvalidArgumentException('You must specify a valid path option.');
        }
        if (!$locale) {
            $locale = $this->getContainer()->getParameter('locale');
        }

        $dumper = $this->getDumper($outputFormat);
        $this->getTranslationWriter()->addDumper($outputFormat, $dumper);
        $files = $this->getFinder()->files()->name('/' . $filename . '\.' . $locale . '\.yml/')->in($this->getTranslationPath());
        foreach ($files as $file) {
            list($domain, $language) = explode('.', $file->getFilename());
            $file = $this->getLoader($inputFormat)->load($file->getRealPath(), $language, $domain);
            if ($file->has($id, $domain)) {
                $file->set($id, $value, $domain);
            } else {
                $file->set($id, $value, $domain);
            }
            try {
                $this->getTranslationWriter()->writeTranslations($file, $outputFormat, array(
                        'path' => $this->getTranslationPath()
                    )
                );
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf('An error has occured while trying to write translations: %s', $e->getMessage()));
            }
        }
    }

    /**
     * Returns Symfony Filesystem component
     *
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        if (null === $this->filesystem) {
            $this->filesystem = new Filesystem();
        }

        return $this->filesystem;
    }

    /**
     * Returns Symfony Finder component
     *
     * @return Finder
     */
    protected function getFinder()
    {
        if (null === $this->finder) {
            $this->finder = new Finder();
        }

        return $this->finder;
    }

    /**
     * Returns Symfony translation writer service
     *
     * @return TranslationWriter
     */
    protected function getTranslationWriter()
    {
        return $this->getContainer()->get('translation.writer');
    }

    /**
     * Returns Symfony requested format loader
     *
     * @param string $format
     *
     * @return \Symfony\Component\Translation\Loader\LoaderInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function getLoader($format)
    {
        $service = sprintf('translation.loader.%s', $format);

        if (!$this->getContainer()->has($service)) {
            throw new \InvalidArgumentException(sprintf('Unable to find Symfony Translation loader for format "%s"', $format));
        }

        return $this->getContainer()->get($service);
    }

    /**
     * Returns Symfony requested format dumper
     *
     * @param string $format
     *
     * @return \Symfony\Component\Translation\Dumper\DumperInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function getDumper($format)
    {
        $service = sprintf('translation.dumper.%s', $format);

        if (!$this->getContainer()->has($service)) {
            throw new \InvalidArgumentException(sprintf('Unable to find Symfony Translation dumper for format "%s"', $format));
        }

        return $this->getContainer()->get($service);
    }

    /**
     * Returns translation path
     *
     * @return string
     */
    protected function getTranslationPath()
    {
        return $this->getContainer()->get('kernel')->getRootDir() . '/../src/Terart/Delegations/DelegationsBundle/Resources/translations';
    }

} 